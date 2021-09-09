<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Enums\StatsPeriods;
use App\Facades\Network;
use App\Services\Cache\CryptoDataCache;
use App\Services\Cache\PriceChartCache;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\Contracts\CryptoDataFetcher;

final class CachePrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'explorer:cache-prices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cache prices and exchange rates.';

    /**
     * @var CryptoDataFetcher
     */
    protected $cryptoDataFetcher = 'Cache currencies data';

    public function __construct(CryptoDataFetcher $cryptoDataFetcher)
    {
        parent::__construct();

        $this->cryptoDataFetcher = $cryptoDataFetcher;
    }

    public function handle(CryptoDataCache $crypto, PriceChartCache $cache): void
    {
        if (! Network::canBeExchanged()) {
            return;
        }

        collect(config('currencies'))->values()->each(function ($currency) use ($crypto, $cache): void {
            $currency = $currency['currency'];
            $prices = $this->cryptoDataFetcher->historical(Network::currency(), $currency);
            $hourlyPrices = $this->cryptoDataFetcher->historicalHourly(Network::currency(), $currency);

            collect([
                StatsPeriods::DAY,
                StatsPeriods::WEEK,
                StatsPeriods::MONTH,
                StatsPeriods::QUARTER,
                StatsPeriods::YEAR,
                StatsPeriods::ALL,
            ])->each(function ($period) use ($currency, $crypto, $cache, $prices, $hourlyPrices): void {
                if ($period === StatsPeriods::DAY) {
                    $prices = $hourlyPrices;
                }

                $crypto->setPrices($currency.'.'.$period, $prices);
                $method = sprintf('get%s', Str::title($period));

                $cache->setHistorical($currency, $period, $this->{$method}($prices));
            });
        });
    }
}
