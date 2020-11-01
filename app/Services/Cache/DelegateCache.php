<?php

declare(strict_types=1);

namespace App\Services\Cache;

use App\Contracts\Cache as Contract;
use Illuminate\Cache\TaggedCache;
use Illuminate\Support\Facades\Cache;

final class DelegateCache implements Contract
{
    use Concerns\ManagesCache;

    public function totalAmounts(): string
    {
        return $this->cacheKey('total_amounts');
    }

    public function totalBlocks(): string
    {
        return $this->cacheKey('total_blocks');
    }

    public function totalFees(): string
    {
        return $this->cacheKey('total_fees');
    }

    public function totalRewards(): string
    {
        return $this->cacheKey('total_rewards');
    }

    public function getCache(): TaggedCache
    {
        return Cache::tags('delegate');
    }
}
