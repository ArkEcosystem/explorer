<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\Monitor;
use App\Services\NumberFormatter;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

final class HomeController
{
    public function __invoke(): View
    {
        $monitor = new Monitor();

        dd(
            $monitor->status('0236d5232cdbd1e7ab87fad10ebe689c4557bc9d0c408b6773be964c837231d5f0'),
            $monitor->status('025341ecfcbb48f9ecac8b87d6e5ace9fb172cee9c521a036f20861f515077bfc3')
        );

        // dd($monitor->lastForged('025341ecfcbb48f9ecac8b87d6e5ace9fb172cee9c521a036f20861f515077bfc3'));

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
        ]);
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
