<?php

declare(strict_types=1);

use App\Models\Block;
use App\Models\Wallet;
use Livewire\Livewire;
use App\Facades\Network;
use App\Services\NumberFormatter;
use App\ViewModels\ViewModelFactory;
use function Tests\fakeCryptoCompare;
use App\Http\Livewire\WalletBlockTable;
use function Tests\configureExplorerDatabase;

beforeEach(function () {
    fakeCryptoCompare();

    configureExplorerDatabase();

    $this->subject = Wallet::factory()->create();
});

it('should list all blocks for the given public key', function () {
    $blocks = Block::factory(10)->create([
        'generator_public_key' => $this->subject->public_key,
    ]);

    $component = Livewire::test(WalletBlockTable::class, [$this->subject->public_key]);

    foreach (ViewModelFactory::collection($blocks) as $block) {
        $component->assertSee($block->id());
        $component->assertSee($block->timestamp());
        $component->assertSee(NumberFormatter::number($block->height()));
        $component->assertSee(NumberFormatter::number($block->transactionCount()));
        $component->assertSee(NumberFormatter::currency($block->amount(), Networkf::currency()));
        $component->assertSee(NumberFormatter::currency($block->fee(), Network::currency()));
    }
});
