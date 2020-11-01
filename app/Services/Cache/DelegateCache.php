<?php

declare(strict_types=1);

namespace App\Services\Cache;

use Illuminate\Cache\TaggedCache;
use Illuminate\Support\Facades\Cache;

final class DelegateCache
{
    use Concerns\HasCacheKey;

    public static function get(): TaggedCache
    {
        return Cache::tags('delegate');
    }

    public static function totalAmounts(): string
    {
        return static::cacheKey('total_amounts');
    }

    public static function totalBlocks(): string
    {
        return static::cacheKey('total_blocks');
    }

    public static function totalFees(): string
    {
        return static::cacheKey('total_fees');
    }

    public static function totalRewards(): string
    {
        return static::cacheKey('total_rewards');
    }
}
