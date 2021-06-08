<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Facades\Network;
use App\Services\Cache\NetworkStatusBlockCache;
use App\Services\CryptoCompare;
use Illuminate\Console\Command;
use Illuminate\Http\Client\ConnectionException;

final class CacheNetworkStatusBlock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'explorer:cache-network-status-block';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cache network status block data.';

    public function handle(NetworkStatusBlockCache $cache): void
    {
        if (! Network::canBeExchanged()) {
            return;
        }

        collect(array_values(config('currencies')))->each(function ($currency) use ($cache) :void {
            $source = Network::currency();
            $target = $currency['currency'];

            try {
                $cache->setPrice($source, $target, CryptoCompare::price($source, $target));
                $cache->setMarketCap($source, $target, CryptoCompare::marketCap($source, $target));
                $cache->setPriceChange($source, $target, CryptoCompare::getPriceChange($source, $target));
                $cache->setHistoricalHourly($source, $target, CryptoCompare::historicalHourly($source, $target));
            } catch (ConnectionException $e) {
                $cache->setPrice($source, $target, null);
                $cache->setMarketCap($source, $target, null);
                $cache->setPriceChange($source, $target, null);
                $cache->setHistoricalHourly($source, $target, null);
            }
        });
    }
}
