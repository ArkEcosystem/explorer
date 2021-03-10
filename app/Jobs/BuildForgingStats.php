<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\ForgingStats;
use App\Services\Monitor\MissedBlocksCalculator;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class BuildForgingStats implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public int $height, public int $numberOfDays)
    {
    }

    public function handle(): void
    {
        $forgingStats = MissedBlocksCalculator::calculateForLastXDays($this->height, $this->numberOfDays);
        foreach ($forgingStats as $publicKey => $statsForPublicKey) {
            $forgingStatsModel = new ForgingStats;
            $forgingStatsModel->public_key = $publicKey;
            $forgingStatsModel->missed_blocks = $statsForPublicKey['missed'];
            $forgingStatsModel->forged_blocks = $statsForPublicKey['forged'];
            $forgingStatsModel->save();
        }
    }
}
