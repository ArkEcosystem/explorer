<?php

declare(strict_types=1);

namespace App\Services\Monitor;

use App\Facades\Network;
use App\Models\Block;
use Illuminate\Support\Collection;

final class DelegateTracker
{
    public static function execute(Collection $delegates): array
    {
        // Arrange Block
        $lastBlock = Block::current();
        $height    = $lastBlock->height->toNumber();
        $timestamp = $lastBlock->timestamp;

        // Arrange Delegates
        $activeDelegates = $delegates->toBase()->map(fn ($delegate) => $delegate->public_key);
        $activeDelegates = static::getActiveDelegates($activeDelegates->toArray(), $height);

        // Arrange Constants
        $maxDelegates = Network::delegateCount();
        $blockTime    = Network::blockTime();

        // Act
        $forgingInfo = ForgingInfoCalculator::calculateForgingInfo($timestamp, $height);

        // Determine Next Forgers...
        $nextForgers = [];
        for ($i = 0; $i < $maxDelegates; $i++) {
            $delegate = $activeDelegates[($forgingInfo['currentForger'] + $i) % $maxDelegates];

            if ($delegate) {
                $nextForgers[] = $delegate;
            }
        }

        if (count($activeDelegates) < $maxDelegates) {
            return [];
        }

        // Map Next Forgers...
        $result = [
            // 'delegates'     => [],
            // 'nextRoundTime' => ($maxDelegates - $forgingInfo['currentForger'] - 1) * $blockTime,
        ];

        foreach ($delegates as $delegate) {
            $indexInNextForgers = 0;

            for ($i = 0; $i < count($nextForgers); $i++) {
                if ($nextForgers[$i] === $delegate->public_key) {
                    $indexInNextForgers = $i;

                    break;
                }
            }

            if ($indexInNextForgers === 0) {
                $result[$indexInNextForgers] = [
                    'publicKey' => $delegate->public_key,
                    'status'    => 'next',
                    'time'      => 0,
                    'order'     => $indexInNextForgers,
                ];
            } elseif ($indexInNextForgers <= $maxDelegates - $forgingInfo['nextForger']) {
                $result[$indexInNextForgers] = [
                    'publicKey' => $delegate->public_key,
                    'status'    => 'pending',
                    'time'      => $indexInNextForgers * $blockTime * 1000,
                    'order'     => $indexInNextForgers,
                ];
            } else {
                $result[$indexInNextForgers] = [
                    'publicKey' => $delegate->public_key,
                    'status'    => 'done',
                    'time'      => 0,
                    'order'     => $indexInNextForgers,
                ];
            }
        }

        return collect($result)->sortBy('order')->toArray();
    }

    private static function getActiveDelegates(array $delegates, int $height): array
    {
        $seedSource  = (string) RoundCalculator::calculate($height)['round'];
        $currentSeed = hex2bin(hash('sha256', $seedSource));
        $delCount    = count($delegates);

        for ($i = 0; $i < $delCount; $i++) {
            for ($x = 0; $x < 4 && $i < $delCount; $i++, $x++) {
                $newIndex             = intval($currentSeed[$x]) % $delCount;
                $b                    = $delegates[$newIndex];
                $delegates[$newIndex] = $delegates[$i];
                $delegates[$i]        = $b;
            }

            $currentSeed = hex2bin(hash('sha256', $currentSeed));
        }

        return $delegates;
    }
}
