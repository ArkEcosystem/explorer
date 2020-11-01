<?php

declare(strict_types=1);

namespace App\Services\Cache;

use App\Contracts\Cache as Contract;
use Illuminate\Cache\TaggedCache;
use Illuminate\Support\Facades\Cache;

final class MonitorCache implements Contract
{
    use Concerns\ManagesCache;

    public function blockCount(): string
    {
        return $this->cacheKey('block_count');
    }

    public function currentDelegate(): string
    {
        return $this->cacheKey('current_delegate');
    }

    public function nextDelegate(): string
    {
        return $this->cacheKey('next_delegate');
    }

    public function transactions(): string
    {
        return $this->cacheKey('transactions');
    }

    public function getCache(): TaggedCache
    {
        return Cache::tags('monitor');
    }
}
