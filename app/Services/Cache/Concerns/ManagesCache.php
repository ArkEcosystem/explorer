<?php

declare(strict_types=1);

namespace App\Services\Cache\Concerns;

use Closure;

trait ManagesCache
{
    /**
     * @return mixed
     */
    private function get(string $key)
    {
        return $this->getCache()->get($key);
    }

    /**
     * @return mixed
     */
    private function remember(string $key, Closure $callback, int $ttl = 60)
    {
        return $this->getCache()->remember($key, $ttl, $callback);
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    private function put(string $key, $value)
    {
        return $this->getCache()->put($key, $value);
    }

    private function cacheKey(string $key, array $arguments = []): string
    {
        return md5(sprintf($key, ...$arguments));
    }
}
