<?php

declare(strict_types=1);

namespace App\Services\Cache;

use Illuminate\Cache\TaggedCache;
use Illuminate\Support\Facades\Cache;

final class MonitorCache
{
    use Concerns\HasCacheKey;

    public static function get(): TaggedCache
    {
        return Cache::tags('monitor');
    }

    public static function blockCount(): string
    {
        return static::cacheKey('block_count');
    }

    public static function currentDelegate(): string
    {
        return static::cacheKey('current_delegate');
    }

    public static function nextDelegate(): string
    {
        return static::cacheKey('next_delegate');
    }

    public static function transactions(): string
    {
        return static::cacheKey('transactions');
    }
}
