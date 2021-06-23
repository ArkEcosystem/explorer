<?php

declare(strict_types=1);

namespace App\Http\Livewire\Concerns;

use App\Facades\Network;
use App\Services\NumberFormatter;
use App\Services\Settings;
use Illuminate\Support\Collection;

trait StatisticsChart
{
    private function transactionsPerPeriod(string $cache, string $period): Collection
    {
        return collect((new $cache())->getHistorical($period));
    }

    private function chartTheme(): Collection
    {
        $mode = Settings::usesDarkTheme() ? 'dark' : 'light';

        return collect(['name' => self::CHART_COLOR, 'mode' => $mode]);
    }

    private function chartValues(string $cache, string $period): Collection
    {
        return $this->transactionsPerPeriod($cache, $period);
    }

    private function sum(string $cache, string $period, string $format): string
    {
        $datasets = $this->transactionsPerPeriod($cache, $period)->get('datasets');
        $sum      = collect($datasets)->sum();

        return $format === 'money'
            ? NumberFormatter::currency($sum, Network::currency())
            : NumberFormatter::number($sum);
    }
}
