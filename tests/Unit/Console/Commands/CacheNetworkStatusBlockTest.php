<?php

declare(strict_types=1);

use App\Services\Blockchain\Network as Blockchain;
use App\Services\Cache\NetworkStatusBlockCache;
use function Tests\configureExplorerDatabase;
use function Tests\fakeCryptoCompare;
use App\Facades\Network;
use App\Console\Commands\CacheNetworkStatusBlock;
use Illuminate\Support\Facades\Config;
use App\Contracts\Network as NetworkContract;

it('should execute the command', function () {
    Config::set('currencies', [
        'usd' => [
            'currency' => 'USD',
            'locale'   => 'en_US',
        ],
    ]);

    fakeCryptoCompare();

    configureExplorerDatabase();

    $this->app->singleton(NetworkContract::class, fn () => new Blockchain(config('explorer.networks.production')));

    $cache = new NetworkStatusBlockCache();

    expect($cache->getPrice(Network::currency(), 'USD'))->toBeNull();
    expect($cache->getMarketCap(Network::currency(), 'USD'))->toBeNull();
    expect($cache->getPriceChange(Network::currency(), 'USD'))->toBeNull();
    expect($cache->getHistoricalHourly(Network::currency(), 'USD'))->toBeNull();

    (new CacheNetworkStatusBlock())->handle($cache);

    expect($cache->getPrice(Network::currency(), 'USD'))->toBe(0.2907);
    expect($cache->getMarketCap(Network::currency(), 'USD'))->toBe(254260570.5975121);
    expect($cache->getPriceChange(Network::currency(), 'USD'))->toBe(-0.136986301369863);
    expect($cache->getHistoricalHourly(Network::currency(), 'USD'))->toEqual(collect([
        '2021-05-18 18:00:00' => '1.898',
        '2021-05-18 19:00:00' => '1.904',
        '2021-05-18 20:00:00' => '1.967',
        '2021-05-18 21:00:00' => '1.941',
        '2021-05-18 22:00:00' => '2.013',
        '2021-05-18 23:00:00' => '2.213',
        '2021-05-19 00:00:00' => '2.414',
        '2021-05-19 01:00:00' => '2.369',
        '2021-05-19 02:00:00' => '2.469',
        '2021-05-19 03:00:00' => '2.374',
        '2021-05-19 04:00:00' => '2.228',
        '2021-05-19 05:00:00' => '2.211',
        '2021-05-19 06:00:00' => '2.266',
        '2021-05-19 07:00:00' => '2.364',
        '2021-05-19 08:00:00' => '2.341',
        '2021-05-19 09:00:00' => '2.269',
        '2021-05-19 10:00:00' => '1.981',
        '2021-05-19 11:00:00' => '1.889',
        '2021-05-19 12:00:00' => '1.275',
        '2021-05-19 13:00:00' => '1.471',
        '2021-05-19 14:00:00' => '1.498',
        '2021-05-19 15:00:00' => '1.518',
        '2021-05-19 16:00:00' => '1.61',
        '2021-05-19 17:00:00' => '1.638',
    ]));
});

it('should ignore the cache for development network', function () {
    Config::set('currencies', [
        'usd' => [
            'currency' => 'USD',
            'locale'   => 'en_US',
        ],
    ]);

    fakeCryptoCompare();

    configureExplorerDatabase();

    $this->app->singleton(NetworkContract::class, fn () => new Blockchain(config('explorer.networks.development')));

    $cache = new NetworkStatusBlockCache();

    expect($cache->getPrice(Network::currency(), 'USD'))->toBeNull();
    expect($cache->getMarketCap(Network::currency(), 'USD'))->toBeNull();
    expect($cache->getPriceChange(Network::currency(), 'USD'))->toBeNull();
    expect($cache->getHistoricalHourly(Network::currency(), 'USD'))->toBeNull();

    (new CacheNetworkStatusBlock())->handle($cache);

    expect($cache->getPrice(Network::currency(), 'USD'))->toBeNull();
    expect($cache->getMarketCap(Network::currency(), 'USD'))->toBeNull();
    expect($cache->getPriceChange(Network::currency(), 'USD'))->toBeNull();
    expect($cache->getHistoricalHourly(Network::currency(), 'USD'))->toBeNull();
});
