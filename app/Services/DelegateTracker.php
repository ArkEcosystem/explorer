<?php

declare(strict_types=1);

namespace App\Services;

use App\Facades\Network;
use App\Models\Block;
use Illuminate\Support\Collection;

final class DelegateTracker
{
    private Collection $delegates;

    public function __construct()
    {
        $this->delegates = (new Monitor())->activeDelegates();
    }

    public function execute(int $height): array
    {
        $lastBlock       = Block::latestByHeight()->firstOrFail();
        $maxDelegates    = Network::delegateCount();
        $blockTime       = Network::blockTime();
        $round           = RoundCalculator::calculate($height);
        $activeDelegates = $this->delegates->toBase()->map(fn ($delegate) => $delegate->public_key);

        $blockTimeLookup = [];
        //     const blockTimeLookup = await Utils.forgingInfoCalculator.getBlockTimeLookup(this.app, height);

        $forgingInfo = [];
        //     const forgingInfo: Contracts.Shared.ForgingInfo = Utils.forgingInfoCalculator.calculateForgingInfo(
        //         timestamp,
        //         height,
        //         blockTimeLookup,
        //     );

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
            'delegates'     => [],
            'nextRoundTime' => ($maxDelegates - $forgingInfo['currentForger'] - 1) * $blockTime,
        ];

        foreach ($this->delegates as $delegate) {
            $indexInNextForgers = 0;
            for ($i = 0; $i < count($nextForgers); $i++) {
                if ($nextForgers[$i] === $delegate->public_key) {
                    $indexInNextForgers = $i;

                    break;
                }
            }

            if ($indexInNextForgers === 0) {
                $result['delegates'][$delegate->public_key] = [
                    'status' => 'next',
                    'time'   => 0,
                ];
            } elseif ($indexInNextForgers <= $maxDelegates - $forgingInfo['nextForger']) {
                $result['delegates'][$delegate->public_key] = [
                    'status' => 'pending',
                    'time'   => $indexInNextForgers * $blockTime * 1000,
                ];
            } else {
                $result['delegates'][$delegate->public_key] = [
                    'status' => 'done',
                    'time'   => 0,
                ];
            }
        }

        return $result;
    }
}
