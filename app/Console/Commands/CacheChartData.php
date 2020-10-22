<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Facades\Network;
use App\Services\CryptoCompare;
use App\Services\Transactions\Aggregates\FeeByRangeAggregate;
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
    protected $signature = 'chart:cache';

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
        $ttl   = Carbon::now()->addHour();
        $today = Carbon::now()->endOfDay();

        if (Network::canBeExchanged()) {
            $this->cachePrices($ttl);
        }

        $this->cacheFees($ttl, $today);
    }

    private function cachePrices(Carbon $ttl): void
    {
        foreach ($this->currencies as $currency) {
            $prices = (new CryptoCompare())->historical(Network::currency(), $currency);

            Cache::remember('chart.prices.day', $ttl, fn () => $this->groupByDate($prices->take(1), 'H:s'));
            Cache::remember('chart.prices.week', $ttl, fn () => $this->groupByDate($prices->take(7), 'd.m'));
            Cache::remember('chart.prices.month', $ttl, fn () => $this->groupByDate($prices->take(30), 'd.m'));
            Cache::remember('chart.prices.quarter', $ttl, fn () => $this->groupByDate($prices->take(120), 'd.m'));
            Cache::remember('chart.prices.year', $ttl, fn () => $this->groupByDate($prices->take(365), 'd.m'));
        }
    }

    private function cacheFees(Carbon $ttl, Carbon $today): void
    {
        $fees = new FeeByRangeAggregate();

        Cache::remember('chart.fees.day', $ttl, fn () => $this->groupByDate($fees->aggregate(Carbon::now()->startOfDay(), $today), 'H:s'));
        Cache::remember('chart.fees.week', $ttl, fn () => $this->groupByDate($fees->aggregate(Carbon::now()->subDays(7), $today), 'd.m'));
        Cache::remember('chart.fees.month', $ttl, fn () => $this->groupByDate($fees->aggregate(Carbon::now()->subDays(30), $today), 'd.m'));
        Cache::remember('chart.fees.quarter', $ttl, fn () => $this->groupByDate($fees->aggregate(Carbon::now()->subDays(120), $today), 'd.m'));
        Cache::remember('chart.fees.year', $ttl, fn () => $this->groupByDate($fees->aggregate(Carbon::now()->subDays(365), $today), 'd.m'));
    }

    private function groupByDate(Collection $datasets, string $dateFormat): array
    {
        $datasets = $datasets
            ->groupBy(fn ($_, $key) => Carbon::parse($key)->format($dateFormat))
            ->reverse()
            ->mapWithKeys(fn ($values, $key) => [$key => $values->first()]);

        return [
            'labels'   => $datasets->keys(),
            'datasets' => $datasets->values(),
        ];
    }
}
