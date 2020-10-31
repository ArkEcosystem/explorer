<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Facades\Wallets;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use App\Services\Monitor\Aggregates\TotalFeesByPublicKeysAggregate;
use App\Services\Monitor\Aggregates\TotalBlocksByPublicKeysAggregate;
use App\Services\Monitor\Aggregates\TotalAmountsByPublicKeysAggregate;
use App\Services\Monitor\Aggregates\TotalRewardsByPublicKeysAggregate;

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

        Cache::put('delegates.totalFees', (new TotalFeesByPublicKeysAggregate())->aggregate($publicKeys));

        Cache::put('delegates.totalAmounts', (new TotalAmountsByPublicKeysAggregate())->aggregate($publicKeys));

        Cache::put('delegates.totalRewards', (new TotalRewardsByPublicKeysAggregate())->aggregate($publicKeys));

        Cache::put('delegates.totalBlocks', (new TotalBlocksByPublicKeysAggregate())->aggregate($publicKeys));
    }
}
