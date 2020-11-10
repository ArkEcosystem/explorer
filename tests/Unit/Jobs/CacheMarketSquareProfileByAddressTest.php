<?php

declare(strict_types=1);

use App\Jobs\CacheMarketSquareProfileByAddress;
use App\Models\Wallet;
use App\Services\Cache\MarketSquareCache;
use Illuminate\Support\Facades\Cache;
use function Tests\configureExplorerDatabase;
use function Tests\fakeMarketSquare;

it('should cache the MarketSquare profile for the address', function () {
    fakeMarketSquare();

    configureExplorerDatabase();

    $wallet = Wallet::factory()->create();

    expect(Cache::tags('marketsquare')->has(md5("profile/$wallet->address")))->toBeFalse();

    (new CacheMarketSquareProfileByAddress($wallet->toArray()))->handle(new MarketSquareCache());

    expect(Cache::tags('marketsquare')->has(md5("profile/$wallet->address")))->toBeTrue();

    expect(Cache::tags('marketsquare')->get(md5("profile/$wallet->address")))->toBeArray();
});
