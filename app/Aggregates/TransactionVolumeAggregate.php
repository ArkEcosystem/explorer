<?php

declare(strict_types=1);

namespace App\Aggregates;

use App\Contracts\Aggregate;
use App\Models\Transaction;
use App\Services\NumberFormatter;

final class TransactionVolumeAggregate implements Aggregate
{
    public function aggregate(): string
    {
        return NumberFormatter::number(Transaction::sum('amount') / 1e8);
    }
}
