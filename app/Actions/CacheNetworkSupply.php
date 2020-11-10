<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Wallet;
use App\Services\Cache\NetworkCache;

final class CacheNetworkSupply
{
    public static function execute(): float
    {
        $supply = Wallet::where('balance', '>', 0)->sum('balance');

        (new NetworkCache())->setSupply((string) $supply);

        return (float) $supply;
    }
}
