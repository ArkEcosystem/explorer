<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Wallet;
use App\Services\Cache\WalletCache;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

final class CacheDelegateVoterCounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'explorer:cache-delegate-voter-counts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cache the voter count for each delegate.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $walletCache = new WalletCache();

        $select = [
            '"wallets"."public_key"',
            'COUNT("voters"."public_key") total',
        ];

        $results = Wallet::whereNotNull('wallets.attributes->delegate->username')
            ->selectRaw(implode(', ', $select))
            ->join(
                'wallets as voters',
                /* @phpstan-ignore-next-line */
                DB::raw('"wallets"."public_key"'),
                /* @phpstan-ignore-next-line */
                DB::raw('("voters"."attributes"->>\'vote\')::text')
            )->groupByRaw('"wallets"."public_key"')
            ->pluck('total', 'public_key');

        $results->each(fn ($total, $publicKey) => $walletCache->setVoterCount($publicKey, $total));
    }
}
