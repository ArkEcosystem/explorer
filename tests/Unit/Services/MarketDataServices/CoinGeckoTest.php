<?php

declare(strict_types=1);

use App\Services\MarketDataServices\CoinGecko;
use Illuminate\Support\Facades\Http;
use function Spatie\Snapshots\assertMatchesSnapshot;

it('should fetch the price data for the given collection', function () {
    Http::fake([
        'api.coingecko.com/*'     => Http::response(json_decode(file_get_contents(base_path('tests/fixtures/coingecko/coin.json')), true), 200),
    ]);

    expect((new CoinGecko())->getCurrenciesData('ARK', collect(['USD'])))->toEqual(collect([
        'USD' => [
            'priceChange' => -0.079771867564,
            'price'       => 1.63,
        ],
    ]));
});

it('should fetch the historical prices for the given pair', function () {
    Http::fake([
        'api.coingecko.com/*'     => Http::response(json_decode(file_get_contents(base_path('tests/fixtures/coingecko/market_data.json')), true), 200),
    ]);

    assertMatchesSnapshot((new CoinGecko())->historical('ARK', 'USD'));
});

it('should fetch the historical prices per hour for the given pair', function () {
    Http::fake([
        'api.coingecko.com/*'     => Http::response(json_decode(file_get_contents(base_path('tests/fixtures/coingecko/market_data_1_day.json')), true), 200),
    ]);

    assertMatchesSnapshot((new CoinGecko())->historicalHourly('ARK', 'USD'));
});