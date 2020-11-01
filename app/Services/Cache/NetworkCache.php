<?php

declare(strict_types=1);

namespace App\Services\Cache;

use App\Contracts\Cache as Contract;
use App\Facades\Network;
use App\Models\Block;
use App\Models\Wallet;
use Illuminate\Cache\TaggedCache;
use Illuminate\Support\Facades\Cache;

final class NetworkCache implements Contract
{
    use Concerns\ManagesCache;

    public function height(): int
    {
        return (int) $this->remember('height', Network::blockTime(), function (): int {
            $block = Block::latestByHeight()->first();

            if (is_null($block)) {
                return 0;
            }

            return $block->height->toNumber();
        });
    }

    public function supply(): string
    {
        return $this->remember('supply', Network::blockTime(), fn () => Wallet::sum('balance'));
    }

    public function getCache(): TaggedCache
    {
        return Cache::tags('network');
    }
}
