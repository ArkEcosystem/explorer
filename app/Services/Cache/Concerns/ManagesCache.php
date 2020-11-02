<?php

declare(strict_types=1);

namespace App\Services\Cache\Concerns;

use Carbon\Carbon;
use Closure;

trait ManagesCache
{
    /**
     * @return mixed
     */
    private function get(string $key)
    {
        return $this->getCache()->get(md5($key));
    }

    /**
     * @param Carbon|int $ttl
     *
     * @return mixed
     */
    private function remember(string $key, $ttl, Closure $callback)
    {
        return $this->getCache()->remember(md5($key), $ttl, $callback);
    }

    /**
     * @return mixed
     */
    private function rememberForever(string $key, Closure $callback)
    {
        return $this->getCache()->rememberForever(md5($key), $callback);
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    private function put(string $key, $value)
    {
        return $this->getCache()->put(md5($key), $value);
    }
}
