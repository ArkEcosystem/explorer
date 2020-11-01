<?php

declare(strict_types=1);

namespace App\Services\Cache;

use Illuminate\Cache\TaggedCache;
use Illuminate\Support\Facades\Cache;

final class TableCache
{
    use Concerns\HasCacheKey;

    public static function get(): TaggedCache
    {
        return Cache::tags('table');
    }

    public static function latestBlocks(string $type): string
    {
        return static::cacheKey('blocks.%s', [$type]);
    }

    public static function latestTransactions(string $type): string
    {
        return static::cacheKey('transactions.%s', [$type]);
    }
}
