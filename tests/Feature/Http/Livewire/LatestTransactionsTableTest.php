<?php

declare(strict_types=1);

use App\Models\Block;
use Ramsey\Uuid\Uuid;
use App\Models\Wallet;
use Livewire\Livewire;
use App\Facades\Network;
use App\Models\Transaction;
use App\Services\NumberFormatter;
use App\ViewModels\ViewModelFactory;
use App\Enums\CoreTransactionTypeEnum;

use App\Enums\TransactionTypeGroupEnum;
use function Tests\configureExplorerDatabase;
use App\Http\Livewire\LatestTransactionsTable;

beforeEach(fn () => configureExplorerDatabase());

it('should list the first page of records', function () {
    Transaction::factory(30)->create();

    $component = Livewire::test(LatestTransactionsTable::class);

    foreach (ViewModelFactory::collection(Transaction::latestByTimestamp()->take(15)->get()) as $transaction) {
        $component->assertSee($transaction->id());
        $component->assertSee($transaction->timestamp());
        $component->assertSee($transaction->sender()->address());
        $component->assertSee($transaction->recipient()->address());
        $component->assertSee(NumberFormatter::currency($transaction->amount(), Network::currency()));
        $component->assertSee(NumberFormatter::currency($transaction->fee(), Network::currency()));
    }
})->skip('Figure out how circumvent wire:loading in tests');

it('should apply filters', function () {
    $block = Block::factory()->create();
    $wallet = Wallet::factory()->create([
        'public_key' => 'public_key',
        'address'    => 'address',
    ]);

    $component = Livewire::test(LatestTransactionsTable::class);

    $notExpected = Transaction::factory(10)->create([
        'id'                => (string) Uuid::uuid4(),
        'block_id'          => $block->id,
        'type'              => TransactionTypeGroupEnum::CORE,
        'type_group'        => CoreTransactionTypeEnum::TRANSFER,
        'sender_public_key' => $wallet->public_key,
        'recipient_id'      => $wallet->address,
        'timestamp'         => 112982056,
        'fee'               => 1e8,
        'amount'            => 1e8,
    ]);

    foreach (ViewModelFactory::collection($notExpected) as $transaction) {
        $component->assertDontSee($transaction->id());
        $component->assertDontSee($transaction->timestamp());
        $component->assertDontSee($transaction->sender()->address());
        $component->assertDontSee($transaction->recipient()->address());
        $component->assertDontSee($transaction->fee());
        $component->assertDontSee($transaction->amount());
    }

    $expected = Transaction::factory(10)->create([
        'type_group' => TransactionTypeGroupEnum::CORE,
        'type'       => CoreTransactionTypeEnum::VOTE,
    ]);

    $component->set('state.type', 'vote');

    foreach (ViewModelFactory::collection($expected) as $transaction) {
        $component->assertSee($transaction->id());
        $component->assertSee($transaction->timestamp());
        $component->assertSee($transaction->sender()->address());
        $component->assertSee($transaction->recipient()->address());
        $component->assertSee($transaction->fee());
        $component->assertSee($transaction->amount());
    }
})->skip('Figure out how circumvent wire:loading in tests');

it('should apply filters through an event', function () {
    $block = Block::factory()->create();
    $wallet = Wallet::factory()->create([
        'public_key' => 'public_key',
        'address'    => 'address',
    ]);

    $component = Livewire::test(LatestTransactionsTable::class);

    $notExpected = Transaction::factory(10)->create([
        'id'                => (string) Uuid::uuid4(),
        'block_id'          => $block->id,
        'type'              => TransactionTypeGroupEnum::CORE,
        'type_group'        => CoreTransactionTypeEnum::TRANSFER,
        'sender_public_key' => $wallet->public_key,
        'recipient_id'      => $wallet->address,
        'timestamp'         => 112982056,
        'fee'               => 1e8,
        'amount'            => 1e8,
    ]);

    foreach (ViewModelFactory::collection($notExpected) as $transaction) {
        $component->assertDontSee($transaction->id());
        $component->assertDontSee($transaction->timestamp());
        $component->assertDontSee($transaction->sender()->address());
        $component->assertDontSee($transaction->recipient()->address());
        $component->assertDontSee($transaction->fee());
        $component->assertDontSee($transaction->amount());
    }

    $expected = Transaction::factory(10)->create([
        'type_group' => TransactionTypeGroupEnum::CORE,
        'type'       => CoreTransactionTypeEnum::VOTE,
    ]);

    $component->emit('filterTransactionsByType', 'vote');

    foreach (ViewModelFactory::collection($expected) as $transaction) {
        $component->assertSee($transaction->id());
        $component->assertSee($transaction->timestamp());
        $component->assertSee($transaction->sender()->address());
        $component->assertSee($transaction->recipient()->address());
        $component->assertSee($transaction->fee());
        $component->assertSee($transaction->amount());
    }
})->skip('Figure out how circumvent wire:loading in tests');
