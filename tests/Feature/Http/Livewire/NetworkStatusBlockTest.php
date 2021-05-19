<?php

declare(strict_types=1);

use App\Http\Livewire\NetworkStatusBlock;
use App\Models\Block;
use App\Models\Wallet;
use App\Services\Cache\CryptoCompareCache;

use Livewire\Livewire;
use function Tests\configureExplorerDatabase;

it('should render with a height, supply and market cap', function () {
    configureExplorerDatabase();

    Block::factory()->create([
        'height'               => 5651290,
        'generator_public_key' => Wallet::factory()->create([
            'balance' => '13628098200000000',
        ])->public_key,
    ]);

    (new CryptoCompareCache())->setPrice('USD', 'USD', fn () => 0.2907);

    Livewire::test(NetworkStatusBlock::class)
        ->assertSee('5,651,290')
        ->assertSee('136,280,982 DARK')
        ->assertSee('Not Available')
        ;
});
