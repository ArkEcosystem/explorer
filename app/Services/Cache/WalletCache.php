<?php

declare(strict_types=1);

namespace App\Services\Cache;

use App\Contracts\Cache as Contract;
use App\Models\Wallet;
use Illuminate\Cache\TaggedCache;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

final class WalletCache implements Contract
{
    use Concerns\ManagesCache;

    public function getKnown(): array
    {
        return $this->get('known');
    }

    public function setKnown(\Closure $callback): array
    {
        return $this->remember('known', now()->addDay(), $callback);
    }

    public function getLastBlock(string $publicKey): array
    {
        return $this->get(sprintf('%s.lastBlock', [$publicKey]));
    }

    public function setLastBlock(string $publicKey, \Closure $callback): array
    {
        return $this->remember(sprintf('%s.lastBlock', [$publicKey]), now()->addMinute(), $callback);
    }

    public function getPerformance(string $publicKey): Collection
    {
        return $this->get(sprintf('%s.performance', [$publicKey]));
    }

    public function setPerformance(string $publicKey, Collection $data): Collection
    {
        return $this->put(sprintf('%s.performance', [$publicKey]), $data);
    }

    public function getProductivity(string $publicKey): float
    {
        return $this->get(sprintf('%s.productivity', [$publicKey]));
    }

    public function setProductivity(string $publicKey, \Closure $callback): float
    {
        return $this->remember(sprintf('%s.productivity', [$publicKey]), now()->addMinute(), $callback);
    }

    public function getResignationId(string $address): string
    {
        return $this->get(sprintf('%s.resignationId', [$address]));
    }

    public function setResignationId(string $address, \Closure $callback): string
    {
        return $this->remember(sprintf('%s.resignationId', [$address]), now()->addMinute(), $callback);
    }

    public function getVote(string $publicKey): string
    {
        return $this->get(sprintf('%s.vote', [$publicKey]));
    }

    public function setVote(string $publicKey, \Closure $callback): Wallet
    {
        return $this->remember(sprintf('%s.vote', [$publicKey]), now()->addMinute(), $callback);
    }

    public function getVotes(string $publicKey): string
    {
        return $this->get(sprintf('%s.votes', [$publicKey]));
    }

    public function setVotes(string $publicKey, \Closure $callback): string
    {
        return $this->remember(sprintf('%s.votes', [$publicKey]), now()->addMinute(), $callback);
    }

    public function getCache(): TaggedCache
    {
        return Cache::tags('wallet');
    }
}
