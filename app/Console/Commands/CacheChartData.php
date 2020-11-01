<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Facades\Network;
use App\Services\Cache\AggregateCache;
use App\Services\Cache\FeeChartCache;
use App\Services\Cache\PriceChartCache;
use App\Services\CryptoCompare;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

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

            Cache::put('prices.'.$currency, $prices);

            $cache = new PriceChartCache();
            $cache->setDay($prices);
            $cache->setWeek($prices);
            $cache->setMonth($prices);
            $cache->setQuarter($prices);
            $cache->setYear($prices);
        }
    }

    private function cacheFees(): void
    {
        $cache = new FeeChartCache();
        $cache->setDay();
        $cache->setWeek();
        $cache->setMonth();
        $cache->setQuarter();
        $cache->setYear();
    }

    private function cacheStatistics(): void
    {
        $cache = new AggregateCache();
        $cache->volume();
        $cache->transactionsCount();
        $cache->voteCount();
        $cache->votesPercentage();
    }

    private function cacheKeyValue(string $key, Collection $datasets): void
    {
        Cache::put($key, [
            'labels'   => $datasets->keys()->toArray(),
            'datasets' => $datasets->values()->toArray(),
        ]);
    }

    private function groupByDate(Collection $datasets, string $dateFormat): Collection
    {
        return $datasets
            ->groupBy(fn ($_, $key) => Carbon::parse($key)->format($dateFormat))
            ->mapWithKeys(fn ($values, $key) => [$key => $values->first()])
            ->ksort();
    }
}
