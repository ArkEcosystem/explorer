<?php

declare(strict_types=1);

use App\Enums\OrderingDirectionEnum;
use App\Enums\OrderingTypeEnum;
use App\Facades\Network;
use App\Http\Livewire\BlockTable;
use App\Models\Block;
use App\Models\Scopes\OrderByHeightDescScope;
use App\Services\NumberFormatter;
use App\ViewModels\ViewModelFactory;
use Livewire\Livewire;
use function Tests\configureExplorerDatabase;

beforeEach(fn () => configureExplorerDatabase());

it('should list the first page of records', function () {
    Block::factory(30)->create();

    $component = Livewire::test(BlockTable::class);

    foreach (ViewModelFactory::paginate(Block::withScope(OrderByHeightDescScope::class)->paginate())->items() as $block) {
        $component->assertSee($block->id());
        $component->assertSee($block->timestamp());
        $component->assertSee($block->username());
        $component->assertSee(NumberFormatter::number($block->height()));
        $component->assertSee(NumberFormatter::number($block->transactionCount()));
        $component->assertSee(NumberFormatter::currency($block->amount(), Network::currency()));
        $component->assertSee(NumberFormatter::currency($block->fee(), Network::currency()));
    }
});

it('should apply ordering through an event', function () {
    $component = Livewire::test(BlockTable::class);

    $component->assertSet('blocksOrdering', OrderingTypeEnum::HEIGHT);
    $component->assertSet('blocksOrderingDirection', OrderingDirectionEnum::DESC);

    $component->emit('orderBlocksBy', OrderingTypeEnum::HEIGHT);

    $component->assertSet('blocksOrdering', OrderingTypeEnum::HEIGHT);
    $component->assertSet('blocksOrderingDirection', OrderingDirectionEnum::ASC);

    $component->emit('orderBlocksBy', OrderingTypeEnum::TRANSACTIONS_AMOUNT);

    $component->assertSet('blocksOrdering', OrderingTypeEnum::TRANSACTIONS_AMOUNT);
    $component->assertSet('blocksOrderingDirection', OrderingDirectionEnum::DESC);
});
