<?php

declare(strict_types=1);

namespace App\Http\Livewire\Concerns;

use App\Services\Cache\PriceChartCache;
use App\Services\Settings;
use Illuminate\Support\Collection;

trait StatisticsChart
{
    private function chartTheme(string $color): Collection
    {
        return collect(['name' => $color, 'mode' => Settings::theme()]);
    }

    private function chartHistoricalPrice(string $period): Collection
    {
        return collect((new PriceChartCache())->getHistorical(Settings::currency(), $period));
    }
}
