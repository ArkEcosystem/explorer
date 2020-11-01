<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Facades\Wallets;
use App\Services\Cache\DelegateCache;
use Illuminate\Console\Command;

final class CacheDelegateAggregates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:delegate-aggregates';

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
    public function handle()
    {
        $publicKeys = Wallets::allWithUsername()->pluck('public_key')->toArray();

        $cache = new DelegateCache();
        $cache->getTotalAmounts($publicKeys);
        $cache->getTotalBlocks($publicKeys);
        $cache->getTotalFees($publicKeys);
        $cache->getTotalRewards($publicKeys);
    }
}
