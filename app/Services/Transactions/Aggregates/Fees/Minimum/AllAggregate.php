<?php

declare(strict_types=1);

namespace App\Services\Transactions\Aggregates\Fees\Minimum;

use App\Models\Transaction;
use App\Services\BigNumber;

final class AllAggregate
{
    public function aggregate(): float
    {
        return BigNumber::new(Transaction::min('fee') ?? 0)->toFloat();
    }
}
