<?php

declare(strict_types=1);

namespace App\Services\Monitor;

use App\Facades\Network;
use App\Models\Block;
use App\Models\Scopes\OrderByHeightScope;
use App\Services\Monitor\Actions\ShuffleDelegates;
use Illuminate\Support\Collection;

final class DelegateTracker
{
    public static function execute(Collection $delegates, int $startHeight): array
    {
        // Arrange Block
        $lastBlock = Block::withScope(OrderByHeightScope::class)->firstOrFail();
        $height    = $lastBlock->height->toNumber();
        $timestamp = $lastBlock->timestamp;

        // Arrange Delegates
        $activeDelegates = $delegates->toBase()->map(fn ($delegate) => $delegate->public_key);

        // TODO: calculate this once for a given round, then cache it as it won't change until next round
        $activeDelegates = ShuffleDelegates::execute($activeDelegates->toArray(), $startHeight);

        // Act
        $forgingInfo = ForgingInfoCalculator::calculate($timestamp, $height);

        // // Determine Next Forgers...
        // $nextForgers = [];
        // for ($i = 0; $i < $maxDelegates; $i++) {
        //     $delegate = $activeDelegates[($forgingInfo['currentForger'] + $i) % $maxDelegates];

        //     if ($delegate) {
        //         $nextForgers[] = $delegate;
        //     }
        // }

        // Map Next Forgers...
        $forgingIndex = 2; // We start at 2 to skip 0 which results in 0 as time and 1 which would be the next forger.

        // Get the original forging info to determine the actual first
        $originalOrder = ForgingInfoCalculator::calculate(Block::where('height', $startHeight)->firstOrFail()->timestamp, $startHeight);

        // Note: static order will be found by shifting the index based on the forging data from above
        $delCount         = Network::delegateCount();
        $delegatesOrdered = [];
        for ($i = $originalOrder['currentForger']; $i < $delCount + $originalOrder['currentForger']; $i++) {
            $delegatesOrdered[] = $activeDelegates[$i % $delCount];
        }

        return collect($delegatesOrdered)
            ->map(function ($publicKey, $index) use (&$forgingIndex, $forgingInfo, $originalOrder, $delCount) {

                // Determine forging order based on the original offset
                $difference = $forgingInfo['currentForger'] - $originalOrder['currentForger'];
                $normalizedOrder = $difference >= 0 ? $difference : $delCount + $difference;

                if ($index === $normalizedOrder) {
                    return [
                        'publicKey' => $publicKey,
                        'status'    => 'next',
                        'time'      => Network::blockTime() * 1000,
                        'order'     => $index,
                    ];
                }

                if ($index > $normalizedOrder) {
                    $nextTime = (($forgingIndex) * Network::blockTime() * 1000);

                    $forgingIndex++;

                    return [
                        'publicKey' => $publicKey,
                        'status'    => 'pending',
                        'time'      => $nextTime,
                        'order'     => $index,
                    ];
                }

                // TODO: we need to handle missed blocks by moving "done" states back to pending when needed
                return [
                    'publicKey' => $publicKey,
                    'status'    => 'done',
                    'time'      => 0,
                    'order'     => $index,
                ];
            })
            ->toArray();
    }
}
