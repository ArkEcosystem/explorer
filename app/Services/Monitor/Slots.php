<?php

declare(strict_types=1);

namespace App\Services\Monitor;

use App\Facades\Network;
use App\Models\Block;
use Carbon\Carbon;

final class Slots
{
    public function getTime(?int $timestamp = null)
    {
        if (is_null($timestamp)) {
            $timestamp = Carbon::now()->unix();
        } else {
            $timestamp = Carbon::createFromTimestamp($timestamp)->unix();
        }

        $start = Network::epoch()->unix();

        return floor(($timestamp - $start) / 1000);
    }

    public function getTimeInMsUntilNextSlot($getTimeStampForBlock)
    {
        $nextSlotTime = $this->getSlotTime($getTimeStampForBlock, $this->getNextSlot($getTimeStampForBlock));
        $now          = $this->getTime();

        return ($nextSlotTime - $now) * 1000;
    }

    public function getSlotNumber(?int $timestamp = null, ?int $height = null)
    {
        if (is_null($timestamp)) {
            $timestamp = $this->getTime();
        }

        $latestHeight = $this->getLatestHeight($height);

        return $this->getSlotInfo($timestamp, $latestHeight)['slotNumber'];
    }

    public function getSlotTime($getTimeStampForBlock, int $slot, ?int $height = null)
    {
        $latestHeight = $this->getLatestHeight($height);

        return $this->calculateSlotTime($slot, $latestHeight, $getTimeStampForBlock);
    }

    public function getNextSlot($getTimeStampForBlock)
    {
        return $this->getSlotNumber($getTimeStampForBlock) + 1;
    }

    public function isForgingAllowed($getTimeStampForBlock, ?int $timestamp, ?int $height)
    {
        if (is_null($timestamp)) {
            $timestamp = $this->getTime();
        }

        $latestHeight = $this->getLatestHeight($height);

        return $this->getSlotInfo($getTimeStampForBlock, $timestamp, $latestHeight)['forgingStatus'];
    }

    public function getSlotInfo(?int $timestamp, ?int $height): array
    {
        if (is_null($timestamp)) {
            $timestamp = $this->getTime();
        }

        $height = $this->getLatestHeight($height);

        $blockTime               = Network::blockTime();
        $totalSlotsFromLastSpan  = 0;
        $lastSpanEndTime         = 0;

        $slotNumberUpUntilThisTimestamp = floor(($timestamp - $lastSpanEndTime) / $blockTime);
        $slotNumber                     = $totalSlotsFromLastSpan + $slotNumberUpUntilThisTimestamp;
        $startTime                      = $lastSpanEndTime + $slotNumberUpUntilThisTimestamp * $blockTime;
        $endTime                        = $startTime + $blockTime - 1;
        $forgingStatus                  = $timestamp < $startTime + floor($blockTime / 2);

        return [
                'blockTime'     => $blockTime,
                'startTime'     => $startTime,
                'endTime'       => $endTime,
                'slotNumber'    => $slotNumber,
                'forgingStatus' => $forgingStatus,
            ];
    }

    private function calculateSlotTime(int $slotNumber, int $height): int
    {
        $blockTime              = Network::blockTime();
        $totalSlotsFromLastSpan = 0;
        $milestoneHeight        = 1;
        $lastSpanEndTime        = 0;

        return $lastSpanEndTime + ($slotNumber - $totalSlotsFromLastSpan) * $blockTime;
    }

    private function getLatestHeight(?int $height): int
    {
        if (! $height) {
            $configConfiguredHeight = Block::latestByHeight()->firstOrFail()->height;

            if (! is_null($configConfiguredHeight)) {
                return $configConfiguredHeight;
            }

            return 1;
        }

        return $height;
    }
}
