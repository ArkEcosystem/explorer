<?php

declare(strict_types=1);

use App\Console\Commands\CachePrices;
use App\Contracts\Network;
use App\Services\Blockchain\Network as Blockchain;
use App\Services\Cache\CryptoCompareCache;
use App\Services\Cache\PriceChartCache;
use Illuminate\Support\Collection;
use function Tests\configureExplorerDatabase;
use function Tests\fakeCryptoCompare;

it('should execute the command', function (string $network) {
    fakeCryptoCompare();

    configureExplorerDatabase();

    $this->app->singleton(Network::class, fn () => new Blockchain(config($network)));

    $crypto = new CryptoCompareCache();
    $prices = new PriceChartCache();

    (new CachePrices())->handle($crypto, $prices);

    expect($crypto->getPrices('USD'))->toBeInstanceOf(Collection::class);
    expect($prices->getHistorical('USD', 'day'))->toBeInstanceOf(Collection::class);
    expect($prices->getHistorical('USD', 'week'))->toBeInstanceOf(Collection::class);
    expect($prices->getHistorical('USD', 'month'))->toBeInstanceOf(Collection::class);
    expect($prices->getHistorical('USD', 'quarter'))->toBeInstanceOf(Collection::class);
    expect($prices->getHistorical('USD', 'year'))->toBeInstanceOf(Collection::class);
})->with(['explorer.networks.development', 'explorer.networks.production']);
