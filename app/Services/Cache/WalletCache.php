<?php

declare(strict_types=1);

namespace App\Services\Cache;

use Illuminate\Cache\TaggedCache;
use Illuminate\Support\Facades\Cache;

final class WalletCache
{
    use Concerns\HasCacheKey;

    public static function get(): TaggedCache
    {
        return Cache::tags('wallet');
    }

    public static function known(): string
    {
        return static::cacheKey('known');
    }

    public static function byAddress(string $address): string
    {
        return static::cacheKey('%s.address', [$address]);
    }

    public static function byPublicKey(string $publicKey): string
    {
        return static::cacheKey('%s.publicKey', [$publicKey]);
    }

    public static function lastBlock(string $publicKey): string
    {
        return static::cacheKey('%s.lastBlock', [$publicKey]);
    }

    public static function performance(string $publicKey): string
    {
        return static::cacheKey('%s.performance', [$publicKey]);
    }

    public static function productivity(string $publicKey): string
    {
        return static::cacheKey('%s.productivity', [$publicKey]);
    }

    public static function resignationId(string $address): string
    {
        return static::cacheKey('%s.resignationId', [$address]);
    }

    public static function votes(string $publicKey): string
    {
        return static::cacheKey('%s.votes', [$publicKey]);
    }
}
