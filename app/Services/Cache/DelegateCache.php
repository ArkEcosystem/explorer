<?php

declare(strict_types=1);

namespace App\Services\Cache;

use App\Contracts\Cache as Contract;
use Illuminate\Cache\TaggedCache;
use Illuminate\Support\Facades\Cache;

final class DelegateCache implements Contract
{
    use Concerns\ManagesCache;

    public function getTotalAmounts(): string
    {
        return $this->get('total_amounts');
    }

    public function setTotalAmounts(\Closure $callback): string
    {
        return $this->remember('total_amounts', now()->addHour(), $callback);
    }

    public function getTotalBlocks(): string
    {
        return $this->get('total_blocks');
    }

    public function setTotalBlocks(\Closure $callback): string
    {
        return $this->remember('total_blocks', now()->addHour(), $callback);
    }

    public function getTotalFees(): string
    {
        return $this->get('total_fees');
    }

    public function setTotalFees(\Closure $callback): string
    {
        return $this->remember('total_fees', now()->addHour(), $callback);
    }

    public function getTotalRewards(): string
    {
        return $this->get('total_rewards');
    }

    public function setTotalRewards(\Closure $callback): string
    {
        return $this->remember('total_rewards', now()->addHour(), $callback);
    }

    public function getCache(): TaggedCache
    {
        return Cache::tags('delegate');
    }
}
