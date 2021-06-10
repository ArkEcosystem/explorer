<?php

declare(strict_types=1);

use App\Contracts\Network as NetworkContract;
use App\Facades\Network;
use App\Jobs\CacheCurrenciesHistory;
use App\Services\Blockchain\Network as Blockchain;
use App\Services\Cache\NetworkStatusBlockCache;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

use function Tests\configureExplorerDatabase;
use function Tests\fakeCryptoCompare;

it('should cache the history', function () {
    fakeCryptoCompare();

    configureExplorerDatabase();

    $this->app->singleton(NetworkContract::class, fn () => new Blockchain(config('explorer.networks.production')));

    $cache = new NetworkStatusBlockCache();

    expect($cache->getHistoricalHourly(Network::currency(), 'USD'))->toBeNull();

    CacheCurrenciesHistory::dispatch('ARK', 'USD');

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

it('set values to null when cryptocompare is down', function () {
    configureExplorerDatabase();

    $this->app->singleton(NetworkContract::class, fn () => new Blockchain(config('explorer.networks.production')));

    $cache = new NetworkStatusBlockCache();

    $cache->setHistoricalHourly(Network::currency(), 'USD', collect());

    Http::fake([
        'cryptocompare.com/*' => function () {
            throw new ConnectionException();
        },
    ]);

    try {
        CacheCurrenciesHistory::dispatch('ARK', 'USD');
    } catch (ConnectionException $e) {
        expect($cache->getHistoricalHourly(Network::currency(), 'USD'))->toBeNull();
    }
});
