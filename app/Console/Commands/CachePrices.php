<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Contracts\MarketDataProvider;
use App\Enums\StatsPeriods;
use App\Facades\Network;
use App\Services\Cache\CryptoDataCache;
use App\Services\Cache\PriceChartCache;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

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

    public function handle(CryptoDataCache $crypto, PriceChartCache $cache, MarketDataProvider $marketDataProvider): void
    {
        if (! Network::canBeExchanged()) {
            return;
        }

        collect((array) config('currencies'))->values()->each(function (array $currency) use ($crypto, $cache, $marketDataProvider): void {
            $currency = $currency['currency'];
            $prices = $marketDataProvider->historical(Network::currency(), $currency);
            $hourlyPrices = $marketDataProvider->historicalHourly(Network::currency(), $currency);

            collect(StatsPeriods::cases())
                ->each(function (StatsPeriods $period) use ($currency, $crypto, $cache, $prices, $hourlyPrices): void {
                    if ($period === StatsPeriods::DAY) {
                        $prices = $hourlyPrices;
                    }

                    $periodValue = $period->value;

                    $crypto->setPrices($currency.'.'.$periodValue, $prices);
                    $cache->setHistorical($currency, $periodValue, $this->statsByPeriod($periodValue, $prices));
                });
        });
    }

    private function statsByPeriod(string $period, Collection $datasets): Collection
    {
        return match ($period) {
            StatsPeriods::DAY->value     => $this->groupByDate($datasets->take(-24), 'H:s'),
            StatsPeriods::WEEK->value    => $this->groupByDate($datasets->take(-7), 'd.m'),
            StatsPeriods::MONTH->value   => $this->groupByDate($datasets->take(-30), 'd.m'),
            StatsPeriods::QUARTER->value => $this->groupByDate($datasets->take(-120), 'd.m'),
            StatsPeriods::YEAR->value    => $this->groupByDate($datasets->take(-365), 'd.m'),
            default                      => $this->groupByDate($datasets, 'm.Y'),
        };
    }

    private function groupByDate(Collection $datasets, string $format): Collection
    {
        return $datasets
            ->groupBy(fn ($_, $key) => Carbon::parse($key)->format($format))
            ->mapWithKeys(fn ($values, $key) => [$key => (float) $values->first()]);
    }
}
