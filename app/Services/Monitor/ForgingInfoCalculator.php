<?php

declare(strict_types=1);

namespace App\Services\Monitor;

use App\Facades\Network;
use App\Models\Block;

final class ForgingInfoCalculator
{
    public function getBlockTimeLookup(int $height): array
    {
        return Block::where('height', $height)->firstOrFail()->timestamp;
    }

    public function calculateForgingInfo(int $timestamp, int $height): array
    {
        $slotInfo = 0; // Crypto.Slots.getSlotInfo(getTimeStampForBlock, timestamp, height);

        [$currentForger, $nextForger] = $this->findIndex($height, $slotInfo['slotNumber']);

        return [
            'currentForger'  => $currentForger,
            'nextForger'     => $nextForger,
            'blockTimestamp' => $slotInfo['startTime'],
            'canForge'       => $slotInfo['forgingStatus'],
        ];
    }

    private function findIndex(int $slotNumber): array
    {
        $lastSpanSlotNumber = 0;
        $activeDelegates    = Network::delegateCount();

        $currentForger = ($slotNumber - $lastSpanSlotNumber) % $activeDelegates;
        $nextForger    = ($currentForger + 1) % $activeDelegates;

        return [$currentForger, $nextForger];
    }
}
