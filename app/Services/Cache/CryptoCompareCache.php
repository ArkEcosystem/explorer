<?php

declare(strict_types=1);

namespace App\Services\Cache;

use Illuminate\Cache\TaggedCache;
use Illuminate\Support\Facades\Cache;

final class CryptoCompareCache
{
    use Concerns\HasCacheKey;

    public static function get(): TaggedCache
    {
        return Cache::tags('crypto_compare');
    }

    public static function cryptoHistorical(string $source, string $target, string $format): string
    {
        return static::cacheKey('historical.%s.%s.%s', [$source, $target, $format]);
    }

    public static function cryptoPrice(string $source, string $target): string
    {
        return static::cacheKey('price.%s.%s', [$source, $target]);
    }

    public static function prices(string $currency): string
    {
        return static::cacheKey('prices.%s', [$currency]);
    }
}
