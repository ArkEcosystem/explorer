<?php

declare(strict_types=1);

namespace App\Services\Cache\Concerns;

trait HasCacheKey
{
    private static function cacheKey(string $key, array $arguments = []): string
    {
        return md5(sprintf($key, ...$arguments));
    }
}
