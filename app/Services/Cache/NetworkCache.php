<?php

declare(strict_types=1);

namespace App\Services\Cache;

use App\Facades\Network;

use Illuminate\Cache\TaggedCache;
use Illuminate\Support\Facades\Cache;

final class NetworkCache
{
    use Concerns\HasCacheKey;

    public static function get(): TaggedCache
    {
        return Cache::tags('network');
    }

    public static function height(): string
    {
        return static::cacheKey('height.%s', [Network::name()]);
    }

    public static function supply(): string
    {
        return static::cacheKey('supply.%s', [Network::name()]);
    }
}
