<?php

declare(strict_types=1);

namespace App\Services\Cache\Concerns;

use Illuminate\Support\Collection;

trait ManagesChart
{
    private function chartjs(Collection $datasets): Collection
    {
        return collect([
            'labels'   => $datasets->keys()->toArray(),
            'datasets' => $datasets->values()->toArray(),
        ]);
    }
}
