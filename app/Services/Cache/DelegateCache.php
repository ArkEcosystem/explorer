<?php

declare(strict_types=1);

namespace App\Services\Cache;

use App\Contracts\Cache as Contract;
use App\Services\Monitor\Aggregates\TotalAmountsByPublicKeysAggregate;
use App\Services\Monitor\Aggregates\TotalBlocksByPublicKeysAggregate;
use App\Services\Monitor\Aggregates\TotalFeesByPublicKeysAggregate;
use App\Services\Monitor\Aggregates\TotalRewardsByPublicKeysAggregate;
use Illuminate\Cache\TaggedCache;
use Illuminate\Support\Facades\Cache;

final class DelegateCache implements Contract
{
    use Concerns\ManagesCache;

    public function getTotalAmounts(array $publicKeys): string
    {
        return $this->rememberForever('total_amounts', fn () => (new TotalFeesByPublicKeysAggregate())->aggregate($publicKeys));
    }

    public function getTotalBlocks(array $publicKeys): string
    {
        return $this->rememberForever('total_blocks', fn () => (new TotalAmountsByPublicKeysAggregate())->aggregate($publicKeys));
    }

    public function getTotalFees(array $publicKeys): string
    {
        return $this->rememberForever('total_fees', fn () => (new TotalRewardsByPublicKeysAggregate())->aggregate($publicKeys));
    }

    public function getTotalRewards(array $publicKeys): string
    {
        return $this->rememberForever('total_rewards', fn () => (new TotalBlocksByPublicKeysAggregate())->aggregate($publicKeys));
    }

    public function getCache(): TaggedCache
    {
        return Cache::tags('delegate');
    }
}
