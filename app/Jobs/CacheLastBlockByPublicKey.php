<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Block;
use App\Models\Scopes\OrderByHeightScope;
use App\Services\Cache\WalletCache;
use App\Services\Timestamp;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class CacheLastBlockByPublicKey implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $publicKey;

    public function __construct(string $publicKey)
    {
        $this->publicKey = $publicKey;
    }

    public function handle(): void
    {
        $block = Block::query()
            ->without(['delegate'])
            ->where('generator_public_key', $this->publicKey)
            ->withScope(OrderByHeightScope::class)
            ->limit(1)
            ->firstOrFail();

        (new WalletCache())->setLastBlock($this->publicKey, [
            'id'                   => $block->id,
            'height'               => $block->height->toNumber(),
            'timestamp'            => Timestamp::fromGenesis($block->timestamp)->unix(),
            'generator_public_key' => $block->generator_public_key,
        ]);
    }
}
