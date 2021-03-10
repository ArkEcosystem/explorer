<?php

declare(strict_types=1);

namespace App\Services\Monitor;

use App\Facades\Network;
use App\Models\Block;

use App\Models\Round;
use App\Services\Monitor\Actions\ShuffleDelegates;

final class MissedBlocksCalculator
{
    public static function calculateForLastXDays(int $height, int $numberOfDays): array
    {
        $heightTimestamp     = Block::where('height', $height)->firstOrFail()->timestamp;

        $timeRangeInSeconds = $numberOfDays * 24 * 60 * 60;
        $startHeight        = Block::where('timestamp', '>', $heightTimestamp - $timeRangeInSeconds)
            ->orderBy('height')
            ->firstOrFail()->height->toNumber();
        $forgingStats = [];
        for ($h = $startHeight; $h <= $height; $h += Network::delegateCount()) {
            $forgingStats = $forgingStats + self::calculateForRound($h);
        }

        return $forgingStats;
    }

    public static function calculateForRound(int $height): array
    {
        $activeDelegates              = Network::delegateCount();
        $lastRoundInfo                = RoundCalculator::calculate($height - $activeDelegates);

        $currentRound                 = $lastRoundInfo['nextRound'];
        $tempDelegateOrderForTheRound = Round::where('round', $currentRound)->orderByRaw('balance DESC, public_key ASC')->pluck('public_key')->toArray();
        $tempDelegateOrderForTheRound = ShuffleDelegates::execute($tempDelegateOrderForTheRound, $height);

        $lastRoundLastBlockHeight = $lastRoundInfo['nextRoundHeight'] - 1;
        $lastRoundLastBlockTs     = Block::where('height', $lastRoundLastBlockHeight)->firstOrFail()->timestamp;

        $actualBlocksTimestamps = Block::where('height', '>', $lastRoundLastBlockHeight)
            ->where('height', '<=', $lastRoundLastBlockHeight + $activeDelegates)
            ->pluck('timestamp')
            ->toArray();

        $firstBlockInRoundTheoricalTimestamp = $lastRoundLastBlockTs + Network::blockTime();
        $slotNumberForFirstTheoricalBlock    = (new Slots())->getSlotInfo($firstBlockInRoundTheoricalTimestamp)['slotNumber'];
        $finalDelegateOrderForRound          = array_merge(
            array_slice($tempDelegateOrderForTheRound, $slotNumberForFirstTheoricalBlock % $activeDelegates),
            array_slice($tempDelegateOrderForTheRound, 0, $slotNumberForFirstTheoricalBlock % $activeDelegates)
        );

        $theoricalBlocksByTimestamp = [];
        $lastActualTimestamp        = count($actualBlocksTimestamps) > 0 ? $actualBlocksTimestamps[count($actualBlocksTimestamps) - 1] : 0;
        for (
            $ts = $firstBlockInRoundTheoricalTimestamp, $i = 0;
            $ts <= $lastActualTimestamp;
            $ts += Network::blockTime(), $i++
        ) {
            $theoricalBlocksByTimestamp[strval($ts)] = $finalDelegateOrderForRound[$i % $activeDelegates];
        }

        $forgeInfoByTimestamp = [];
        foreach ($theoricalBlocksByTimestamp as $ts => $delegate) {
            $forgeInfoByTimestamp[$ts] = [
                'publicKey' => $delegate,
                'forged' => in_array($ts, $actualBlocksTimestamps, true),
            ];
        }

        return $forgeInfoByTimestamp;
    }
}
