<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Contracts\CryptoDataFetcher;
use App\Facades\Network;
use App\Services\Cache\NetworkStatusBlockCache;
use Illuminate\Console\Command;
use Illuminate\Http\Client\ConnectionException;

final class CacheCurrenciesData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'explorer:cache-currencies-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cache currencies data';

    /**
     * @var CryptoDataFetcher
     */
    protected $cryptoDataFetcher = 'Cache currencies data';

    public function __construct(CryptoDataFetcher $cryptoDataFetcher)
    {
        parent::__construct();

        $this->cryptoDataFetcher = $cryptoDataFetcher;
    }

    public function handle(NetworkStatusBlockCache $cache): void
    {
        // if (! Network::canBeExchanged()) {
        //     return;
        // }

        $source     = Network::currency();
        $currencies = collect(config('currencies'))->pluck('currency');

        try {
            $currenciesData = $this->cryptoDataFetcher->getCurrenciesData($source, $currencies);

            dd($currencies->map(fn($currency) => \Illuminate\Support\Str::lower($currency))->join(','));

            $currenciesData->each(function ($data, $currency) use ($source, $cache) : void {
                ['price' => $price, 'priceChange' => $priceChange] = $data;
                $cache->setPrice($source, $currency, $price);
                $cache->setPriceChange($source, $currency, $priceChange);
            });
        } catch (ConnectionException $e) {
            $currencies->each(function ($currency) use ($source, $cache) : void {
                $cache->setPrice($source, $currency, null);
                $cache->setPriceChange($source, $currency, null);
            });
        }
    }
}
