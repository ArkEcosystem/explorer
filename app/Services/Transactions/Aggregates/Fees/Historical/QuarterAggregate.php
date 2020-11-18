<?php

declare(strict_types=1);

namespace App\Services\Transactions\Aggregates\Fees\Historical;

use App\Services\Transactions\Aggregates\Fees\Concerns\HasPlaceholders;
use App\Services\Transactions\Aggregates\Fees\Concerns\HasQueries;
use Carbon\Carbon;
use Illuminate\Support\Collection;

final class QuarterAggregate
{
    use HasPlaceholders;
    use HasQueries;

    public function aggregate(): Collection
    {
        return $this->mergeWithPlaceholders(
            (new RangeAggregate())->aggregate(Carbon::now()->subDays(90), Carbon::now(), 'M'),
            $this->placeholders((int) Carbon::now()->subDays(90)->timestamp + 86400, (int) Carbon::now()->timestamp + 86400, 86400, 'M')->reverse()->take(3)->reverse()
        );
    }
}
