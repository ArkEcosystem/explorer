<?php

declare(strict_types=1);

use App\Http\Livewire\DelegateDataBoxes;
use App\Models\Block;
use App\Models\Round;
use App\Models\Wallet;
use App\Services\Cache\WalletCache;
use App\ViewModels\WalletViewModel;
use Livewire\Livewire;
use function Tests\configureExplorerDatabase;

function createRoundWithDelegates(): void
{
    Wallet::factory(51)->create()->each(function ($wallet) {
        $block = Block::factory()->create([
            'height'               => 5720529,
            'timestamp'            => 113620904,
            'generator_public_key' => $wallet->public_key,
        ]);

        // Start height for round 112168
        Block::factory()->create([
            'height'               => 5720518,
            'timestamp'            => 113620904,
            'generator_public_key' => $wallet->public_key,
        ]);

        Round::factory()->create([
            'round'      => '112168',
            'public_key' => $wallet->public_key,
        ]);

        (new WalletCache())->setDelegate($wallet->public_key, $wallet);

        (new WalletCache())->setLastBlock($wallet->public_key, [
            'id'     => $block->id,
            'height' => $block->height->toNumber(),
        ]);
    });
}

beforeEach(fn () => configureExplorerDatabase());

// @TODO: make assertions about data visibility
it('should render without errors', function () {
    createRoundWithDelegates();

    $component = Livewire::test(DelegateDataBoxes::class);
    $component->call('pollStatistics');
    $component->assertHasNoErrors();
    $component->assertViewIs('livewire.delegate-data-boxes');
});

it('should return the block count', function () {
    createRoundWithDelegates();

    $component = Livewire::test(DelegateDataBoxes::class);

    expect($component->instance()->getBlockCount())->toBeString();
});

it('should return the next delegate', function () {
    createRoundWithDelegates();

    $component = Livewire::test(DelegateDataBoxes::class);

    expect($component->instance()->getNextdelegate())->toBeInstanceOf(WalletViewModel::class);
});
