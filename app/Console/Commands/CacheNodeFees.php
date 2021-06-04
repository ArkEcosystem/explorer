<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\Cache\NodeFeesCache;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

final class CacheNodeFees extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'explorer:cache-node-fees';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cache expensive node fees aggregates.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(NodeFeesCache $cache)
    {
        $network = Config::get('explorer.network');

        $endpoint = Config::get(sprintf('explorer.node-fees.%s.endpoint', $network));

        $cache->setAggregates(collect(Http::get($endpoint, ['day' => 20])->json()));
    }
}
