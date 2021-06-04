<?php

declare(strict_types=1);

namespace App\Services\Transactions\Aggregates\Fees\Maximum;

use App\Models\Transaction;
use App\Services\BigNumber;

final class AllAggregate
{
    public function aggregate(): float
    {
        return BigNumber::new(Transaction::max('fee') ?? 0)->toFloat();
    }
}
