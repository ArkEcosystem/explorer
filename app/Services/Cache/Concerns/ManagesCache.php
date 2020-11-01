<?php

declare(strict_types=1);

namespace App\Services\Cache\Concerns;

use Closure;

trait ManagesCache
{
    /**
     * @return mixed
     */
    private function remember(string $key, int $ttl, Closure $callback)
    {
        return $this->getCache()->remember($key, $ttl, $callback);
    }

    /**
     * @return mixed
     */
    private function put(string $key, Closure $callback)
    {
        return $this->getCache()->put($key, $callback);
    }

    private function cacheKey(string $key, array $arguments = []): string
    {
        return md5(sprintf($key, ...$arguments));
    }
}
