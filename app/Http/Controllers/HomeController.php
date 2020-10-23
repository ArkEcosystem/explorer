<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Aggregates\TransactionCountAggregate;
use App\Aggregates\TransactionVolumeAggregate;
use App\Aggregates\VoteCountAggregate;
use App\Aggregates\VotePercentageAggregate;
use App\Facades\Network;
use App\Services\CryptoCompare;
use App\Services\NumberFormatter;
use App\Services\Settings;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

final class HomeController
{
    public function __invoke(): View
    {
        return view('app.home', [
            'prices' => [
                'day'     => $this->getChart('chart.prices.day'),
                'week'    => $this->getChart('chart.prices.week'),
                'month'   => $this->getChart('chart.prices.month'),
                'quarter' => $this->getChart('chart.prices.quarter'),
                'year'    => $this->getChart('chart.prices.year'),
            ],
            'fees' => [
                'day'     => $this->getChart('chart.fees.day'),
                'week'    => $this->getChart('chart.fees.week'),
                'month'   => $this->getChart('chart.fees.month'),
                'quarter' => $this->getChart('chart.fees.quarter'),
                'year'    => $this->getChart('chart.fees.year'),
            ],
            'aggregates' => [
                'price'             => $this->getPrice(),
                'volume'            => $this->getVolume(),
                'transactionsCount' => $this->getTransactionsCount(),
                'votesCount'        => $this->getVotesCount(),
                'votesPercentage'   => $this->getVotesPercentage(),
            ],
        ]);
    }

    private function getPrice()
    {
        return NumberFormatter::number(CryptoCompare::price(Network::currency(), Settings::currency()));
    }

    private function getVolume()
    {
        // TODO: cache this every X minutes
        return (new TransactionVolumeAggregate())->aggregate();
    }

    private function getTransactionsCount()
    {
        // TODO: cache this every X minutes
        return (new TransactionCountAggregate())->aggregate();
    }

    private function getVotesCount()
    {
        // TODO: cache this every X minutes
        return (new VoteCountAggregate())->aggregate();
    }

    private function getVotesPercentage()
    {
        // TODO: cache this every X minutes
        return (new VotePercentageAggregate())->aggregate();
    }

    private function getChart(string $cacheKey): array
    {
        $data     = Cache::get($cacheKey, []);
        $labels   = Arr::get($data, 'labels', []);
        $datasets = Arr::get($data, 'datasets', []);
        $numbers  = collect($datasets)->map(fn ($dataset) => (float) $dataset);

        return [
            'labels'   => $labels,
            'datasets' => $datasets,
            'min'      => NumberFormatter::number($numbers->min()),
            'avg'      => NumberFormatter::number($numbers->avg()),
            'max'      => NumberFormatter::number($numbers->max()),
        ];
    }
}
