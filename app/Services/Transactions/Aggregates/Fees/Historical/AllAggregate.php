<?php

declare(strict_types=1);

namespace App\Services\Transactions\Aggregates\Fees\Historical;

use App\Models\Transaction;
use App\Services\Timestamp;
use Illuminate\Support\Collection;

final class AllAggregate
{
    public function aggregate(string $format): Collection
    {
        return Transaction::query()
            ->orderBy('timestamp')
            ->get()
            ->groupBy(fn ($date) => Timestamp::fromGenesis($date->timestamp)->format($format))
            ->mapWithKeys(fn ($transactions, $day) => [$day => $transactions->sumBigNumber('fee')->toNumber() / 1e8]);
    }
}
