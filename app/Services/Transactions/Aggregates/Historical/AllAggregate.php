<?php

declare(strict_types=1);

namespace App\Services\Transactions\Aggregates\Historical;

use App\Models\Transaction;
use App\Services\Timestamp;
use Illuminate\Support\Collection;

final class AllAggregate
{
    public function aggregate(): Collection
    {
        return Transaction::query()
            ->orderBy('timestamp')
            ->get()
            ->groupBy(fn ($date) => Timestamp::fromGenesis($date->timestamp)->format('M'))
            ->mapWithKeys(fn ($transactions, $day) => [$day => $transactions->count()]);
    }
}
