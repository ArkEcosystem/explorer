<?php

declare(strict_types=1);

namespace App\Services\Monitor;

use App\Contracts\RoundRepository;
use App\Facades\Network;

final class Monitor
{
    public static function roundNumber(): int
    {
        return resolve(RoundRepository::class)->currentRound()->round;
    }

    public static function heightRangeByRound(int $round): array
    {
        $roundStart = (int) ($round - 1) * Network::delegateCount();

        return [$roundStart, $roundStart + 50];
    }
}
