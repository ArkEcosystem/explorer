<?php

declare(strict_types=1);

namespace App\Services\Monitor;

use App\Facades\Network;
use App\Models\Block;

use App\Models\Round;
use App\Services\Monitor\Actions\ShuffleDelegates;

final class MissedBlocksCalculator
{
    //currently calculating stats only for the current round TODO last 30 days, or last x days/rounds
    public static function calculate(int $height): array
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

        $forgeInfoByDelegates = [];
        foreach ($theoricalBlocksByTimestamp as $ts => $delegate) {
            $forgeInfoByDelegates[$delegate] = isset($forgeInfoByDelegates[$delegate]) ? $forgeInfoByDelegates[$delegate] : ['forged' => 0, 'missed' => 0];
            if (in_array($ts, $actualBlocksTimestamps, true)) {
                $forgeInfoByDelegates[$delegate]['forged']++;
            } else {
                $forgeInfoByDelegates[$delegate]['missed']++;
            }
        }

        return $forgeInfoByDelegates;
    }
}
