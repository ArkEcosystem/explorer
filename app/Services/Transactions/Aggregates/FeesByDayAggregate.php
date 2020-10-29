<?php

declare(strict_types=1);

namespace App\Services\Transactions\Aggregates;

use App\Services\Transactions\Aggregates\Concerns\HasPlaceholders;
use App\Services\Transactions\Aggregates\Concerns\HasQueries;
use Carbon\Carbon;
use Illuminate\Support\Collection;

final class FeesByDayAggregate
{
    use HasPlaceholders;
    use HasQueries;

    public function aggregate(): Collection
    {
        return $this->mergeWithPlaceholders(
            (new FeesByRangeAggregate())->aggregate(Carbon::now()->subDay()->startOfDay(), Carbon::now()->endOfDay(), 'H:i'),
            86400,
            3600,
            'H:i'
        );
    }
}
