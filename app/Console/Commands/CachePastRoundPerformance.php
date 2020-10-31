<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Contracts\RoundRepository;
use App\Jobs\CachePastRoundPerformanceByPublicKey;
use App\Services\Monitor\Monitor;
use Illuminate\Console\Command;

final class CachePastRoundPerformance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:past-round-performance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cache the past performance for each active delegate in the current round.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        resolve(RoundRepository::class)
            ->allByRound(Monitor::roundNumber())
            ->each(fn ($round) => CachePastRoundPerformanceByPublicKey::dispatch($round->round, $round->public_key));
    }
}
