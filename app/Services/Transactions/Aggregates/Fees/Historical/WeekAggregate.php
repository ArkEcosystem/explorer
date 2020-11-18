<?php

declare(strict_types=1);

namespace App\Services\Transactions\Aggregates\Fees\Historical;

use App\Services\Transactions\Aggregates\Fees\Concerns\HasPlaceholders;
use App\Services\Transactions\Aggregates\Fees\Concerns\HasQueries;
use Carbon\Carbon;
use Illuminate\Support\Collection;

final class WeekAggregate
{
    use HasPlaceholders;
    use HasQueries;

    public function aggregate(): Collection
    {
        return $this->mergeWithPlaceholders(
            (new RangeAggregate())->aggregate(Carbon::now()->subDays(6), Carbon::now()->addDay(), 'd.m'),
            $this->placeholders((int) Carbon::now()->subDays(6)->timestamp, (int) Carbon::now()->addDay()->timestamp, 86400, 'd.m')->take(7)
        );
    }
}
