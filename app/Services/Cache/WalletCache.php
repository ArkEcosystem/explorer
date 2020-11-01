<?php

declare(strict_types=1);

namespace App\Services\Cache;

use App\Actions\CalculateProductivityByPublicKey;
use App\Actions\FindLastBlockByPublicKey;
use App\Contracts\Cache as Contract;
use App\Models\Scopes\DelegateResignationScope;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Services\Timestamp;
use Illuminate\Cache\TaggedCache;
use Illuminate\Support\Facades\Cache;

final class WalletCache implements Contract
{
    use Concerns\ManagesCache;

    public function known(): string
    {
        return $this->cacheKey('known');
    }

    public function getByAddress(string $address): string
    {
        return $this->remember($this->cacheKey('%s.address', [$address]), 60, function () use ($address) {
            return Wallet::where('public_key', $address)->firstOrFail();
        });
    }

    public function getByPublicKey(string $publicKey): string
    {
        return $this->remember($this->cacheKey('%s.publicKey', [$publicKey]), 60, function () use ($publicKey) {
            return Wallet::where('public_key', $publicKey)->firstOrFail();
        });
    }

    public function getLastBlock(string $publicKey): string
    {
        return $this->remember($this->cacheKey('%s.lastBlock', [$publicKey]), 60, function () use ($publicKey) {
            $block = FindLastBlockByPublicKey::execute($publicKey);

            return [
                'id'                   => $block->id,
                'height'               => $block->height->toNumber(),
                'timestamp'            => Timestamp::fromGenesis($block->timestamp)->unix(),
                'generator_public_key' => $block->generator_public_key,
            ];
        });
    }

    public function getPerformance(string $publicKey): string
    {
        return $this->remember($this->cacheKey('%s.performance', [$publicKey]), 60, function () {
            //
        });
    }

    public function getProductivity(string $publicKey): string
    {
        return $this->remember($this->cacheKey('%s.productivity', [$publicKey]), 60, function () use ($publicKey) {
            return CalculateProductivityByPublicKey::execute($publicKey);
        });
    }

    public function getResignationId(string $address): string
    {
        return $this->remember($this->cacheKey('%s.resignationId', [$address]), 60, function () {
            return Transaction::withScope(DelegateResignationScope::class)->firstOrFail()->id;
        });
    }

    public function getVotes(string $publicKey): string
    {
        return $this->remember($this->cacheKey('%s.votes', [$publicKey]), 60, function () {
            //
        });
    }

    public function getCache(): TaggedCache
    {
        return Cache::tags('wallet');
    }
}
