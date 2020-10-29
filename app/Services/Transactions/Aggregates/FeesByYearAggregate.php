<?php

declare(strict_types=1);

namespace App\Services\Transactions\Aggregates;

use App\Services\Transactions\Aggregates\Concerns\HasQueries;
use Carbon\Carbon;
use Illuminate\Support\Collection;

final class FeesByYearAggregate
{
    use HasQueries;

    public function aggregate(): Collection
    {
        return (new FeeByRangeAggregate())->aggregate(Carbon::now()->subDays(365), Carbon::now()->endOfDay(), 'M');
    }
}
