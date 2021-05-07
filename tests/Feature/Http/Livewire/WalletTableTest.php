<?php

declare(strict_types=1);

use App\Enums\OrderingDirectionEnum;
use App\Enums\OrderingTypeEnum;
use App\Facades\Network;
use App\Http\Livewire\WalletTable;
use App\Models\Scopes\OrderByBalanceDescScope;
use App\Models\Wallet;
use App\Services\Cache\NetworkCache;
use App\Services\NumberFormatter;
use App\ViewModels\ViewModelFactory;
use Livewire\Livewire;
use function Tests\configureExplorerDatabase;

beforeEach(fn () => configureExplorerDatabase());

it('should list the first page of records', function () {
    (new NetworkCache())->setSupply(fn () => strval(10e8));

    Wallet::factory(30)->create();

    $component = Livewire::test(WalletTable::class);

    foreach (ViewModelFactory::paginate(Wallet::withScope(OrderByBalanceDescScope::class)->paginate())->items() as $wallet) {
        $component->assertSee($wallet->address());
        $component->assertSee(NumberFormatter::currency($wallet->balance(), Network::currency()));
    }
});

it('should apply ordering through an event', function () {
    $component = Livewire::test(WalletTable::class);

    $component->assertSet('ordering', OrderingTypeEnum::BALANCE);
    $component->assertSet('orderingDirection', OrderingDirectionEnum::DESC);

    $component->emit('orderWalletsBy', OrderingTypeEnum::BALANCE);

    $component->assertSet('ordering', OrderingTypeEnum::BALANCE);
    $component->assertSet('orderingDirection', OrderingDirectionEnum::ASC);

    $component->emit('orderWalletsBy', OrderingTypeEnum::SUPPLY);

    $component->assertSet('ordering', OrderingTypeEnum::SUPPLY);
    $component->assertSet('orderingDirection', OrderingDirectionEnum::DESC);
});
