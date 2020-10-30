<?php

declare(strict_types=1);

use App\Models\Wallet;
use Livewire\Livewire;
use App\Facades\Network;

use App\Services\NumberFormatter;
use App\ViewModels\ViewModelFactory;
use App\Http\Livewire\Tables\Wallets;
use function Tests\configureExplorerDatabase;

beforeEach(fn () => configureExplorerDatabase());

it('should list the first page of records', function () {
    Wallet::factory(30)->create();

    $component = Livewire::test(Wallets::class, [
        'wallets' => Wallet::wealthy(),
    ]);

    foreach (ViewModelFactory::paginate(Wallet::wealthy()->paginate())->items() as $wallet) {
        $component->assertSee($wallet->address());
        $component->assertSee(NumberFormatter::currency($wallet->balance(), Network::currency()));
    }
});
