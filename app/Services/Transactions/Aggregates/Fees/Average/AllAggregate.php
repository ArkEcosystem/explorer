<?php

declare(strict_types=1);

namespace App\Services\Transactions\Aggregates\Fees\Average;

use App\Models\Transaction;
use App\Services\BigNumber;

final class AllAggregate
{
    public function aggregate(): float
    {
        return BigNumber::new(Transaction::avg('fee') ?? 0)->toFloat();
    }
}
