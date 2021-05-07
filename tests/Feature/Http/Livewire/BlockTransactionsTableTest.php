<?php

declare(strict_types=1);

use App\Enums\OrderingDirectionEnum;
use App\Enums\OrderingTypeEnum;
use App\Facades\Network;
use App\Http\Livewire\BlockTransactionsTable;
use App\Models\Block;
use App\Models\Transaction;
use App\Services\NumberFormatter;

use App\ViewModels\ViewModelFactory;
use Livewire\Livewire;

it('should list the first transactions for the giving block id', function () {
    $block = Block::factory()->create();
    Transaction::factory(25)->create(['block_id' => $block->id]);

    $component = Livewire::test(BlockTransactionsTable::class, ['blockId' => $block->id]);

    foreach (ViewModelFactory::paginate($block->transactions()->paginate(25))->items() as $transaction) {
        $component->assertSee($transaction->id());
        $component->assertSee($transaction->timestamp());
        $component->assertSee($transaction->sender()->address());
        $component->assertSee($transaction->recipient()->address());
        $component->assertSee(NumberFormatter::currency($transaction->amount(), Network::currency()));
        $component->assertSee(NumberFormatter::currency($transaction->fee(), Network::currency()));
    }
});

it('should apply ordering through an event', function () {
    $block = Block::factory()->create();
    Transaction::factory(25)->create(['block_id' => $block->id]);

    $component = Livewire::test(BlockTransactionsTable::class, ['blockId' => $block->id]);

    $component->assertSet('ordering', OrderingTypeEnum::TIMESTAMP);
    $component->assertSet('orderingDirection', OrderingDirectionEnum::DESC);

    $component->emit('orderTransactionsBy', OrderingTypeEnum::RECIPIENT);

    $component->assertSet('ordering', OrderingTypeEnum::RECIPIENT);
    $component->assertSet('orderingDirection', OrderingDirectionEnum::DESC);

    $component->emit('orderTransactionsBy', OrderingTypeEnum::FEE);

    $component->assertSet('ordering', OrderingTypeEnum::FEE);
    $component->assertSet('orderingDirection', OrderingDirectionEnum::DESC);
});
