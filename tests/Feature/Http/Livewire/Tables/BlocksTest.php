<?php

declare(strict_types=1);

use App\Models\Block;
use Livewire\Livewire;
use App\Facades\Network;
use App\Services\NumberFormatter;
use App\Http\Livewire\Tables\Blocks;
use App\ViewModels\ViewModelFactory;
use function Tests\configureExplorerDatabase;

beforeEach(fn () => configureExplorerDatabase());

it('should list the first page of records', function () {
    Block::factory(30)->create();

    $component = Livewire::test(Blocks::class, [
        'blocks' => Block::latestByHeight(),
    ]);

    foreach (ViewModelFactory::paginate(Block::latestByHeight()->paginate())->items() as $block) {
        $component->assertSee($block->id());
        $component->assertSee($block->timestamp());
        $component->assertSee($block->username());
        $component->assertSee(NumberFormatter::number($block->height()));
        $component->assertSee(NumberFormatter::number($block->transactionCount()));
        $component->assertSee(NumberFormatter::currency($block->amount(), Network::currency()));
        $component->assertSee(NumberFormatter::currency($block->fee(), Network::currency()));
    }
});
