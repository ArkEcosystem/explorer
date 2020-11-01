<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Aggregates\TransactionCountAggregate;
use App\Aggregates\TransactionVolumeAggregate;
use App\Aggregates\VoteCountAggregate;
use App\Aggregates\VotePercentageAggregate;
use App\Facades\Network;
use App\Services\Cache\AggregateCache;
use App\Services\Cache\CryptoCompareCache;
use App\Services\Cache\FeeChartCache;
use App\Services\Cache\PriceChartCache;
use App\Services\CryptoCompare;
use App\Services\Transactions\Aggregates\FeesByDayAggregate;
use App\Services\Transactions\Aggregates\FeesByMonthAggregate;
use App\Services\Transactions\Aggregates\FeesByQuarterAggregate;
use App\Services\Transactions\Aggregates\FeesByWeekAggregate;
use App\Services\Transactions\Aggregates\FeesByYearAggregate;
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

            $cache = new CryptoCompareCache();
            $cache->setPrices($currency, $prices);

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
        $cache = new FeeChartCache();

        $cache->setDay((new FeesByDayAggregate())->aggregate());
        $cache->setWeek((new FeesByWeekAggregate())->aggregate());
        $cache->setMonth((new FeesByMonthAggregate())->aggregate());
        $cache->setQuarter((new FeesByQuarterAggregate())->aggregate());
        $cache->setYear((new FeesByYearAggregate())->aggregate());
    }

    private function cacheStatistics(): void
    {
        $cache = new AggregateCache();

        $cache->volume((new TransactionVolumeAggregate())->aggregate());
        $cache->transactionsCount((new TransactionCountAggregate())->aggregate());
        $cache->votesCount((new VoteCountAggregate())->aggregate());
        $cache->votesPercentage((new VotePercentageAggregate())->aggregate());
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
