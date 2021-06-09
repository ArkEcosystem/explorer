<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Facades\Network;
use App\Services\Cache\NetworkStatusBlockCache;
use App\Services\CryptoCompare;
use Illuminate\Console\Command;

final class CacheCurrenciesHistory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'explorer:cache-currencies-history { }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cache currencies history';

    public function handle(NetworkStatusBlockCache $cache): void
    {
        if (! Network::canBeExchanged()) {
            return;
        }

        $source     = Network::currency();
        $currencies = collect(config('currencies'))->pluck('currency');

        $currencies->each(function ($currency, $index) use ($source, $cache) {
            // Cache one currency history per-minute
            if ($this->option('no-delay')) {
                $delay = null;
            } else {
                $delay = now()->addMinutes($index);
            }

            dispatch(fn () => $cache->setHistoricalHourly($source, $currency, CryptoCompare::historicalHourly($source, $currency)))
                ->delay($delay)
                ->catch(fn () => $cache->setHistoricalHourly($source, $currency, null));
        });
    }
}
