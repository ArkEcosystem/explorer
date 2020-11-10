<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Block;
use App\Models\Scopes\OrderByHeightScope;
use App\Services\Cache\NetworkCache;

final class CacheNetworkHeight
{
    public static function execute(): int
    {
        $block = Block::withScope(OrderByHeightScope::class)->first();

        if (is_null($block)) {
            $height = 0;
        } else {
            $height = $block->height->toNumber();
        }

        (new NetworkCache())->setHeight($height);

        return $height;
    }
}
