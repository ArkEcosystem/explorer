<?php

declare(strict_types=1);

namespace App\Services\Cache;

use Illuminate\Cache\TaggedCache;
use Illuminate\Support\Facades\Cache;

final class BlockCache
{
    use Concerns\HasCacheKey;

    public static function get(): TaggedCache
    {
        return Cache::tags('block');
    }

    public static function byId(string $id): string
    {
        return static::cacheKey('id.%s', [$id]);
    }
}
