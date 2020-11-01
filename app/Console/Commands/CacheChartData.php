<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Facades\Network;
use App\Services\Cache\AggregateCache;
use App\Services\Cache\CryptoCompareCache;
use App\Services\Cache\FeeChartCache;
use App\Services\Cache\PriceChartCache;
use App\Services\CryptoCompare;
use Illuminate\Console\Command;

final class CacheChartData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:charts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * The currencies that can be looked up.
     *
     * @var string[]
     */
    protected $currencies = [
        'AUD',
        'BRL',
        'BTC',
        'CAD',
        'CHF',
        'CNY',
        'ETH',
        'EUR',
        'GBP',
        'JPY',
        'KRW',
        'LTC',
        'NZD',
        'RUB',
        'USD',
    ];

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (Network::canBeExchanged()) {
            $this->cachePrices();
        }

        $this->cacheFees();

        $this->cacheStatistics();
    }

    private function cachePrices(): void
    {
        foreach ($this->currencies as $currency) {
            $prices = (new CryptoCompare())->historical(Network::currency(), $currency);

            // @TODO
            $cache = new CryptoCompareCache();
            $cache->setPrices($currency, $prices);

            // @TODO
            $cache = new PriceChartCache();
            $cache->setDay($currency, $prices);
            $cache->setWeek($currency, $prices);
            $cache->setMonth($currency, $prices);
            $cache->setQuarter($currency, $prices);
            $cache->setYear($currency, $prices);
        }
    }

    private function cacheFees(): void
    {
        // @TODO
        $cache = new FeeChartCache();

        $cache->getDay();
        $cache->getWeek();
        $cache->getMonth();
        $cache->getQuarter();
        $cache->getYear();
    }

    private function cacheStatistics(): void
    {
        // @TODO
        $cache = new AggregateCache();

        $cache->getVolume();
        $cache->getTransactionsCount();
        $cache->getVotesCount();
        $cache->getVotesPercentage();
    }
}
