<?php

declare(strict_types=1);

use App\Models\Block;
use Livewire\Livewire;
use App\Facades\Network;
use App\Services\NumberFormatter;
use App\ViewModels\ViewModelFactory;
use App\Http\Livewire\LatestBlocksTable;
use function Tests\configureExplorerDatabase;

beforeEach(fn () => configureExplorerDatabase());

it('should list the first page of records', function () {
    Block::factory(30)->create();

    $component = Livewire::test(LatestBlocksTable::class);

    foreach (ViewModelFactory::collection(Block::latestByHeight()->take(15)->get()) as $block) {
        $component->assertSee($block->id());
        $component->assertSee($block->timestamp());
        $component->assertSee($block->username());
        $component->assertSee(NumberFormatter::number($block->height()));
        $component->assertSee(NumberFormatter::number($block->transactionCount()));
        $component->assertSee(NumberFormatter::currency($block->amount(), Network::currency()));
        $component->assertSee(NumberFormatter::currency($block->fee(), Network::currency()));
    }
})->skip('Figure out how circumvent wire:loading in tests');
