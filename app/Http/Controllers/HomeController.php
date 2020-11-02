<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\Cache\FeeChartCache;
use App\Services\Cache\NetworkCache;
use App\Services\Cache\PriceChartCache;
use App\Services\ExchangeRate;
use App\Services\NumberFormatter;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\View\View;

final class HomeController
{
    public function __invoke(NetworkCache $network, PriceChartCache $prices, FeeChartCache $fees): View
    {
        return view('app.home', [
            'prices' => [
                'day'     => $this->getChart($prices->getDay()),
                'week'    => $this->getChart($prices->getWeek()),
                'month'   => $this->getChart($prices->getMonth()),
                'quarter' => $this->getChart($prices->getQuarter()),
                'year'    => $this->getChart($prices->getYear()),
            ],
            'fees' => [
                'day'     => $this->getChart($fees->getDay()),
                'week'    => $this->getChart($fees->getWeek()),
                'month'   => $this->getChart($fees->getMonth()),
                'quarter' => $this->getChart($fees->getQuarter()),
                'year'    => $this->getChart($fees->getYear()),
            ],
            'aggregates' => [
                'price'             => ExchangeRate::now(),
                'volume'            => $network->getVolume(),
                'transactionsCount' => $network->getTransactionsCount(),
                'votesCount'        => $network->getVotesCount(),
                'votesPercentage'   => $network->getVotesPercentage(),
            ],
        ]);
    }

    private function getChart(Collection $data): array
    {
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
