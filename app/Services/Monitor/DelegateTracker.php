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
        // Arrange
        $lastBlock = Block::current();
        $height    = $lastBlock->height->toNumber();
        $timestamp = $lastBlock->timestamp;

        // Act
        $maxDelegates    = Network::delegateCount();
        $blockTime       = Network::blockTime();
        // $activeDelegates = $delegates->toBase()->map(fn ($delegate) => $delegate->public_key);
        $activeDelegates = static::getActiveDelegates(
            $delegates
                ->toBase()
                ->map(fn ($delegate) => $delegate->public_key)
                ->toArray(), $height
        );
        $forgingInfo     = ForgingInfoCalculator::calculateForgingInfo($timestamp, $height);

        dd($forgingInfo);

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
        $currentSeed = hash('sha256', $seedSource);

        for ($i = 0, $delCount = count($delegates); $i < $delCount; $i++) {
            for ($x = 0; $x < 4 && $i < $delCount; $i++, $x++) {
                $newIndex             = $currentSeed[$x] % $delCount;
                $b                    = $delegates[$newIndex];
                $delegates[$newIndex] = $delegates[$i];
                $delegates[$i]        = $b;
            }
            $currentSeed = hash('sha256', $currentSeed);
        }

        return $delegates;
    }
}
