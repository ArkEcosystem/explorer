<?php

declare(strict_types=1);

namespace App\Services\Cache;

use App\Contracts\Cache as Contract;
use Illuminate\Cache\TaggedCache;
use Illuminate\Support\Facades\Cache;

final class WalletCache implements Contract
{
    use Concerns\ManagesCache;

    public function known(): string
    {
        return $this->cacheKey('known');
    }

    public function byAddress(string $address): string
    {
        return $this->cacheKey('%s.address', [$address]);
    }

    public function byPublicKey(string $publicKey): string
    {
        return $this->cacheKey('%s.publicKey', [$publicKey]);
    }

    public function lastBlock(string $publicKey): string
    {
        return $this->cacheKey('%s.lastBlock', [$publicKey]);
    }

    public function performance(string $publicKey): string
    {
        return $this->cacheKey('%s.performance', [$publicKey]);
    }

    public function productivity(string $publicKey): string
    {
        return $this->cacheKey('%s.productivity', [$publicKey]);
    }

    public function resignationId(string $address): string
    {
        return $this->cacheKey('%s.resignationId', [$address]);
    }

    public function votes(string $publicKey): string
    {
        return $this->cacheKey('%s.votes', [$publicKey]);
    }

    public function getCache(): TaggedCache
    {
        return Cache::tags('wallet');
    }
}
