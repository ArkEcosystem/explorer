<?php

declare(strict_types=1);

namespace App\Services\Monitor;

use App\Facades\Network;
use App\Services\Monitor\Actions\ShuffleDelegates;

use App\Models\Block;
use App\Models\Round;

final class MissedBlocksCalculator 
{
    //currently calculating stats only for the current round TODO last 30 days, or last x days/rounds
    public static function calculate(int $height): array
    {
        $lastRoundInfo = RoundCalculator::calculate($height - $activeDelegates);

        $currentRound = $lastRoundInfo->nextRound;
        $tempDelegateOrderForTheRound = Round::where('round', $currentRound)->orderByRaw('balance DESC, public_key ASC')->pluck('public_key');
        $tempDelegateOrderForTheRound = ShuffleDelegates::execute($tempDelegateOrderForTheRound, $height);
        $activeDelegates    = Network::delegateCount();

        $lastRoundLastBlockHeight = $lastRoundInfo['nextRoundHeight'] - 1;
        $lastRoundLastBlockTs = Block::where('height', $lastRoundLastBlockTs)->firstOrFail()->timestamp;

        $actualBlocksTimestamps = Block::where('height', '>', $lastRoundLastBlockHeight)
            ->where('height', '<=', $lastRoundLastBlockHeight + $activeDelegates)
            ->pluck('timestamp');

        $firstBlockInRoundTheoricalTimestamp = $lastRoundLastBlockTs + Network::blockTime();
        $slotNumberForFirstTheoricalBlock = Slots::getSlotInfo($firstBlockInRoundTheoricalTimestamp)->slotNumber;
        $finalDelegateOrderForRound = array_merge(
            array_slice($tempDelegateOrderForTheRound, $slotNumberForFirstTheoricalBlock % $activeDelegates),
            array_slice($tempDelegateOrderForTheRound, 0, $slotNumberForFirstTheoricalBlock % $activeDelegates)
        );

        $theoricalBlocksByTimestamp = [];
        for (
            $ts = $firstBlockInRoundTheoricalTimestamp, $i = 0;
            $ts <= $actualBlocksTimestamps->end();
            $ts += Network::blockTime(), $i++
        ) {
            $theoricalBlocksByTimestamp[strval($ts)] = $finalDelegateOrderForRound[$i];
        }

        $forgeInfoByDelegates = [];
        foreach ($theoricalBlocksByTimestamp as $ts => $delegate) {
            $forgeInfoByDelegates[$delegate] = isset($forgeInfoByDelegates) ?: [ 'forged' => 0, 'missed' => 0];
            if (in_array($ts, $actualBlocksTimestamps)) {
                $forgeInfoByDelegates[$delegate]->forged++;
            } else {
                $forgeInfoByDelegates[$delegate]->missed++;
            }
        }

        return $forgeInfoByDelegates;
    }
}
