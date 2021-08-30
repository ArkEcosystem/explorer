<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Block;
use App\Facades\Wallets;
use Illuminate\Console\Command;
use App\Services\Cache\DelegateCache;
use App\Services\Monitor\Aggregates\TotalDelegateAggregate;

final class CacheDelegateAggregates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'explorer:cache-delegate-aggregates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cache expensive aggregation data for all delegates.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(DelegateCache $cache)
    {
        $aggregate = (new TotalDelegateAggregate)->aggregate();

        $cache->setTotalAmounts($aggregate->pluck('total_amount', 'generator_public_key'));

        $cache->setTotalFees($aggregate->pluck('total_fee', 'generator_public_key'));

        $cache->setTotalRewards($aggregate->pluck('reward', 'generator_public_key'));

        $cache->setTotalBlocks($aggregate->pluck('count', 'generator_public_key'));

    }
}
