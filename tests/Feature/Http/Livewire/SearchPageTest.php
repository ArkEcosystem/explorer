<?php

declare(strict_types=1);

use App\Enums\CoreTransactionTypeEnum;
use App\Enums\TransactionTypeGroupEnum;
use App\Http\Livewire\SearchPage;
use App\Models\Block;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Services\Cache\NetworkCache;
use App\Services\Timestamp;
use Carbon\Carbon;
use Livewire\Livewire;
use function Tests\configureExplorerDatabase;

beforeEach(function () {
    configureExplorerDatabase();

    (new NetworkCache())->setSupply(strval(10e8));
});

it('should search for blocks', function () {
    $block = Block::factory()->create();

    Livewire::test(SearchPage::class)
        ->set('state.type', 'block')
        ->set('state.term', $block->id)
        ->call('performSearch')
        ->assertSee($block->id);
});

it('should search for transactions', function () {
    $transaction = Transaction::factory()->create([
        'type'       => CoreTransactionTypeEnum::TRANSFER,
        'type_group' => TransactionTypeGroupEnum::CORE,
    ]);

    Livewire::test(SearchPage::class)
        ->set('state.type', 'transaction')
        ->set('state.term', $transaction->id)
        ->call('performSearch')
        ->assertSee($transaction->id);
});

it('should search for wallets', function () {
    $wallet = Wallet::factory()->create();

    Livewire::test(SearchPage::class)
        ->set('state.type', 'wallet')
        ->set('state.term', $wallet->address)
        ->call('performSearch')
        ->assertSee($wallet->address);
});

it('should search for a block by id', function () {
    $block = Block::factory(10)->create()[0];

    $results = Livewire::test(SearchPage::class)
        ->set('state.type', 'block')
        ->set('state.term', $block->id)
        ->call('performSearch')
        ->assertSee($block->id);
});

it('should search for blocks by timestamp minimum', function () {
    $today = Carbon::now();
    $todayGenesis = Timestamp::fromUnix($today->unix())->unix();

    $yesterday = Carbon::now()->subDay();
    $yesterdayGenesis = Timestamp::fromUnix($yesterday->unix())->unix();

    $blocks = Block::factory(10)->create(['timestamp' => $todayGenesis]);
    Block::factory(10)->create(['timestamp' => $yesterdayGenesis]);

    Livewire::test(SearchPage::class)
        ->set('state.type', 'block')
        ->set('state.dateFrom', $today->toString())
        ->call('performSearch')
        ->assertSeeInOrder($blocks->pluck('id')->toArray());
});

it('should search for blocks by timestamp maximum', function () {
    $today = Carbon::now();
    $todayGenesis = Timestamp::fromUnix($today->unix())->unix();

    $yesterday = Carbon::now()->subDay();
    $yesterdayGenesis = Timestamp::fromUnix($yesterday->unix())->unix();

    Block::factory(10)->create(['timestamp' => $todayGenesis]);
    $blocks = Block::factory(10)->create(['timestamp' => $yesterdayGenesis]);

    Livewire::test(SearchPage::class)
        ->set('state.type', 'block')
        ->set('state.dateTo', $yesterday->toString())
        ->call('performSearch')
        ->assertSeeInOrder($blocks->pluck('id')->toArray());
});

it('should search for blocks by timestamp range', function () {
    $today = Carbon::now();
    $todayGenesis = Timestamp::fromUnix($today->unix())->unix();

    $yesterday = Carbon::now()->subDay();
    $yesterdayGenesis = Timestamp::fromUnix($yesterday->unix())->unix();

    Block::factory(10)->create(['timestamp' => $todayGenesis]);
    $blocks = Block::factory(10)->create(['timestamp' => $yesterdayGenesis]);

    Livewire::test(SearchPage::class)
        ->set('state.type', 'block')
        ->set('state.dateFrom', $yesterday->toString())
        ->set('state.dateTo', $yesterday->toString())
        ->call('performSearch')
        ->assertSeeInOrder($blocks->pluck('id')->toArray());
});

it('should search for blocks by total_amount minimum', function () {
    Block::factory(10)->create(['total_amount' => 1000 * 1e8]);
    $blocks = Block::factory(10)->create(['total_amount' => 2000 * 1e8]);

    Livewire::test(SearchPage::class)
        ->set('state.type', 'block')
        ->set('state.totalAmountFrom', 2000)
        ->call('performSearch')
        ->assertSeeInOrder($blocks->pluck('id')->toArray());
});

it('should search for blocks by total_amount maximum', function () {
    $blocks = Block::factory(10)->create(['total_amount' => 1000 * 1e8]);
    Block::factory(10)->create(['total_amount' => 2000 * 1e8]);

    Livewire::test(SearchPage::class)
        ->set('state.type', 'block')
        ->set('state.totalAmountTo', 1000)
        ->call('performSearch')
        ->assertSeeInOrder($blocks->pluck('id')->toArray());
});

it('should search for blocks by total_amount range', function () {
    $blocks = Block::factory(10)->create(['total_amount' => 1000 * 1e8]);
    Block::factory(10)->create(['total_amount' => 2000 * 1e8]);

    Livewire::test(SearchPage::class)
        ->set('state.type', 'block')
        ->set('state.totalAmountFrom', 500)
        ->set('state.totalAmountTo', 1500)
        ->call('performSearch')
        ->assertSeeInOrder($blocks->pluck('id')->toArray());
});

it('should search for blocks by total_fee minimum', function () {
    Block::factory(10)->create(['total_fee' => 1000 * 1e8]);
    $blocks = Block::factory(10)->create(['total_fee' => 2000 * 1e8]);

    Livewire::test(SearchPage::class)
        ->set('state.type', 'block')
        ->set('state.totalFeeFrom', 2000)
        ->call('performSearch')
        ->assertSeeInOrder($blocks->pluck('id')->toArray());
});

it('should search for blocks by total_fee maximum', function () {
    $blocks = Block::factory(10)->create(['total_fee' => 1000 * 1e8]);
    Block::factory(10)->create(['total_fee' => 2000 * 1e8]);

    Livewire::test(SearchPage::class)
        ->set('state.type', 'block')
        ->set('state.totalFeeTo', 2000)
        ->call('performSearch')
        ->assertSeeInOrder($blocks->pluck('id')->toArray());
});

it('should search for blocks by total_fee range', function () {
    $blocks = Block::factory(10)->create(['total_fee' => 1000 * 1e8]);
    Block::factory(10)->create(['total_fee' => 2000 * 1e8]);

    Livewire::test(SearchPage::class)
        ->set('state.type', 'block')
        ->set('state.totalFeeFrom', 500)
        ->set('state.totalFeeTo', 1500)
        ->call('performSearch')
        ->assertSeeInOrder($blocks->pluck('id')->toArray());
});

it('should search for blocks by height minimum', function () {
    $heightStart = 1000;
    $heightEnd = 2000;

    Block::factory(10)->create(['height' => $heightStart]);
    $blocks = Block::factory(10)->create(['height' => $heightEnd]);

    Livewire::test(SearchPage::class)
        ->set('state.type', 'block')
        ->set('state.heightFrom', $heightEnd)
        ->call('performSearch')
        ->assertSeeInOrder($blocks->pluck('id')->toArray());
});

it('should search for blocks by height maximum', function () {
    $heightStart = 1000;
    $heightEnd = 2000;

    $blocks = Block::factory(10)->create(['height' => $heightStart]);
    Block::factory(10)->create(['height' => $heightEnd]);

    Livewire::test(SearchPage::class)
        ->set('state.type', 'block')
        ->set('state.heightTo', $heightStart)
        ->call('performSearch')
        ->assertSeeInOrder($blocks->pluck('id')->toArray());
});

it('should search for blocks by height range', function () {
    $heightStart = 1000;
    $heightEnd = 2000;

    $blocks = Block::factory(10)->create(['height' => $heightStart]);
    Block::factory(10)->create(['height' => $heightEnd]);

    Livewire::test(SearchPage::class)
        ->set('state.type', 'block')
        ->set('state.heightFrom', 500)
        ->set('state.heightTo', 1500)
        ->call('performSearch')
        ->assertSeeInOrder($blocks->pluck('id')->toArray());
});

it('should search for blocks by reward range minimum', function () {
    Block::factory(10)->create(['reward' => 1000 * 1e8]);
    $blocks = Block::factory(10)->create(['reward' => 2000 * 1e8]);

    Livewire::test(SearchPage::class)
        ->set('state.type', 'block')
        ->set('state.rewardFrom', 2000)
        ->call('performSearch')
        ->assertSeeInOrder($blocks->pluck('id')->toArray());
});

it('should search for blocks by reward range maximum', function () {
    $blocks = Block::factory(10)->create(['reward' => 1000 * 1e8]);
    Block::factory(10)->create(['reward' => 2000 * 1e8]);

    Livewire::test(SearchPage::class)
        ->set('state.type', 'block')
        ->set('state.rewardTo', 1000)
        ->call('performSearch')
        ->assertSeeInOrder($blocks->pluck('id')->toArray());
});

it('should search for blocks by reward range range', function () {
    $blocks = Block::factory(10)->create(['reward' => 1000 * 1e8]);
    Block::factory(10)->create(['reward' => 2000 * 1e8]);

    Livewire::test(SearchPage::class)
        ->set('state.type', 'block')
        ->set('state.rewardFrom', 500)
        ->set('state.rewardTo', 1500)
        ->call('performSearch')
        ->assertSeeInOrder($blocks->pluck('id')->toArray());
});

it('should search for blocks by generator with an address', function () {
    Block::factory(10)->create();

    $wallet = Wallet::factory()->create();

    $block = Block::factory()->create([
        'generator_public_key' => $wallet->public_key,
    ]);

    Livewire::test(SearchPage::class)
        ->set('state.type', 'block')
        ->set('state.term', $wallet->address)
        ->call('performSearch')
        ->assertSee($block->id);
});

it('should search for blocks by generator with a public key', function () {
    Block::factory(10)->create();

    $wallet = Wallet::factory()->create();

    $block = Block::factory()->create([
        'generator_public_key' => $wallet->public_key,
    ]);

    Livewire::test(SearchPage::class)
        ->set('state.type', 'block')
        ->set('state.generatorPublicKey', $wallet->public_key)
        ->call('performSearch')
        ->assertSee($block->id);
});

it('should search for blocks by generator with a username', function () {
    Block::factory(10)->create();

    $wallet = Wallet::factory()->create([
        'attributes' => [
            'delegate' => [
                'username' => 'johndoe',
            ],
        ],
    ]);

    $block = Block::factory()->create([
        'generator_public_key' => $wallet->public_key,
    ]);

    Livewire::test(SearchPage::class)
        ->set('state.type', 'block')
        ->set('state.term', 'johndoe')
        ->call('performSearch')
        ->assertSee($block->id);
});
