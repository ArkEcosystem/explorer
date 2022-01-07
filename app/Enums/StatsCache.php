<?php

declare(strict_types=1);

namespace App\Enums;

use App\Services\Cache\FeeCache;
use App\Services\Cache\TransactionCache;

enum StatsCache
{
    case FEES;

    case TRANSACTIONS;

    public function key(): string
    {
        return match ($this) {
            StatsCache::FEES         => FeeCache::class,
            StatsCache::TRANSACTIONS => TransactionCache::class,
        };
    }
}
