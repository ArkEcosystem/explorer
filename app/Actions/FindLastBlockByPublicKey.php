<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Block;

final class FindLastBlockByPublicKey
{
    public static function execute(string $publicKey): Block
    {
        return Block::query()
            ->without(['delegate'])
            ->where('generator_public_key', $publicKey)
            ->latestByHeight()
            ->limit(1)
            ->firstOrFail();
    }
}
