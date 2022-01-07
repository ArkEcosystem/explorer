<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Enums\StatsPeriods;
use App\Services\Cache\FeeCache;
use App\Services\Forms;
use App\Services\Transactions\Aggregates\Fees\HistoricalAggregateFactory;
use App\Services\Transactions\Aggregates\Fees\LastFeeAggregate;
use Illuminate\Console\Command;

final class CacheFees extends Command
{
    private const LAST_20 = 'last20';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'explorer:cache-fees';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cache expensive fee aggregates.';

    public function handle(FeeCache $cache): void
    {
        collect(StatsPeriods::cases())
            ->each(fn (StatsPeriods $period) => $cache->setHistorical($period->value, HistoricalAggregateFactory::make($period->value)->aggregate()));

        collect(Forms::getTransactionOptions())
            ->except(StatsPeriods::ALL->value)
            ->keys()
            ->each(function (string $type) use ($cache): void {
                preg_match('#^[a-z]+(\d+)$#', self::LAST_20, $match);

                $result = (new LastFeeAggregate())
                    ->setLimit((int) $match[1])
                    ->setType($type)
                    ->aggregate();

                $cache->setMinimum($type, $result['minimum']);
                $cache->setAverage($type, $result['average']);
                $cache->setMaximum($type, $result['maximum']);
            });
    }
}
