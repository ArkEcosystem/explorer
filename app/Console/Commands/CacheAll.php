<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\Cache\DelegateCache;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

final class CacheAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Caches all the cachable data';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(DelegateCache $cache)
    {
        $commands = [
            'delegate-aggregates',
            'delegates',
            'exchange-rates',
            'chart-fee',
            'last-blocks',
            'musig',
            'statistics',
            'past-round-performance',
            'past-round-performance',
            'usernames',
            'real-time-statistics',
            'resignation-ids',
        ];

        foreach ($commands as $command) {
            Artisan::call('cache:'.$command);
        }
    }
}
