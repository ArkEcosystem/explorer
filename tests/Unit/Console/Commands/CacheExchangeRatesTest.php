<?php

declare(strict_types=1);

use App\Console\Commands\CacheExchangeRates;
use App\Contracts\Network;
use App\Services\Blockchain\Networks\ARK\Production;
use App\Services\Cache\CryptoCompareCache;
use App\Services\Cache\PriceChartCache;

use Illuminate\Support\Collection;
use function Tests\configureExplorerDatabase;
use function Tests\fakeCryptoCompare;

it('should execute the command', function () {
    fakeCryptoCompare();

    configureExplorerDatabase();

    $this->app->singleton(Network::class, fn ($app) => new Production());

    $crypto = new CryptoCompareCache();
    $prices = new PriceChartCache();

    (new CacheExchangeRates())->handle($crypto, $prices);

    expect($crypto->getPrices('USD'))->toBeInstanceOf(Collection::class);
    expect($prices->getDay('USD'))->toBeArray();
    expect($prices->getWeek('USD'))->toBeArray();
    expect($prices->getMonth('USD'))->toBeArray();
    expect($prices->getQuarter('USD'))->toBeArray();
    expect($prices->getYear('USD'))->toBeArray();
});
