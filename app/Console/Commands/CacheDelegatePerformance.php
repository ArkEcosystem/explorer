<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Monitor\Monitor;
use App\Facades\Network;
use App\Models\Round;
use App\Services\Cache\WalletCache;
use Illuminate\Support\Facades\DB;

final class CacheDelegatePerformance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'explorer:cache-delegate-performance';

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
        $round = Monitor::roundNumber();

        $query = Round::query()
            ->where('round', $round)
            ->limit(Network::delegateCount())
            ->select([
                'rounds.public_key',
                DB::raw('MAX(balance) as balance')
            ])
            ->join('blocks', 'blocks.generator_public_key', '=', 'rounds.public_key');

        collect(range($round - 6, $round - 2))->map(function ($round): array {
            $roundStart = (int) $round * Network::delegateCount();

            return [
                'min' => $roundStart,
                'max' => $roundStart + Network::delegateCount(),
            ];
        })->each(function (array $range, int $index) use ($query) {
            $query->addSelect(DB::raw(sprintf('SUM(CASE WHEN blocks.height BETWEEN %s AND  %s THEN 1 else 0 end) > 0 round_%s', $range['min'], $range['max'], $index)));
        });

        $query
            ->orderBy('balance', 'desc')
            ->orderBy('public_key', 'asc')
            ->groupBy('rounds.public_key');

        $query->get()->each(function ($item) {
            (new WalletCache())->setPerformance($item->public_key, [
                $item->round_0,
                $item->round_1,
                $item->round_2,
                $item->round_3,
                $item->round_4,
            ]);
        });
    }
}
