<?php

declare(strict_types=1);

namespace App\Actions;

use App\Facades\Network;
use App\Models\Block;
use App\Models\Wallet;
use App\Services\Timestamp;
use Mattiasgeniar\Percentage\Percentage;

final class CalculateProductivityByPublicKey
{
    public static function execute(string $publicKey): float
    {
        $delegate = Wallet::where('public_key', $publicKey)->firstOrFail();

        $blocksTotal            = (86400 * 30) / Network::blockTime();
        $blocksDelegateExpected = (int) ceil($blocksTotal / Network::delegateCount());
        $blocksDelegateActual   = Block::query()
            ->where('timestamp', '>=', Timestamp::now()->subDays(30)->unix())
            ->where('generator_public_key', $publicKey)
            ->count();

        return Percentage::calculate($blocksDelegateActual, $blocksDelegateExpected);
    }
}
