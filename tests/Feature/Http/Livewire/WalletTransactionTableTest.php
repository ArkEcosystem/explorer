<?php

declare(strict_types=1);

use App\Enums\CoreTransactionTypeEnum;
use App\Enums\TransactionTypeGroupEnum;
use App\Facades\Network;
use App\Http\Livewire\WalletTransactionTable;
use App\Models\Block;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Services\Cache\CryptoCompareCache;
use App\Services\NumberFormatter;
use App\Services\Settings;
use App\ViewModels\ViewModelFactory;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Livewire\Livewire;
use Ramsey\Uuid\Uuid;
use function Tests\configureExplorerDatabase;
use function Tests\fakeCryptoCompare;

beforeEach(function () {
    fakeCryptoCompare();

    configureExplorerDatabase();

    $this->subject = Wallet::factory()->create();
});

it('should list all transactions', function () {
    $sent = Transaction::factory()->create([
        'sender_public_key' => $this->subject->public_key,
    ]);

    $received = Transaction::factory()->create([
        'recipient_id' => $this->subject->address,
    ]);

    $component = Livewire::test(WalletTransactionTable::class, [$this->subject->address, false, $this->subject->public_key]);
    $component->set('state.direction', 'all');

    foreach (ViewModelFactory::collection(collect([$sent, $received])) as $transaction) {
        $component->assertSee($transaction->id());
        $component->assertSee($transaction->timestamp());
        $component->assertSee($transaction->sender()->address());
        $component->assertSee($transaction->recipient()->address());
        $component->assertSee(NumberFormatter::currency($transaction->fee(), Network::currency()));
        $component->assertSee(NumberFormatter::currency($transaction->amount(), Network::currency()));
    }
});

it('should list all transactions for cold wallet', function () {
    $received = Transaction::factory()->create([
        'recipient_id' => $this->subject->address,
    ]);

    $component = Livewire::test(WalletTransactionTable::class, [$this->subject->address, true, null]);
    $component->set('state.direction', 'all');

    $transaction = ViewModelFactory::make($received);
    $component->assertSee($transaction->id());
    $component->assertSee($transaction->timestamp());
    $component->assertSee($transaction->sender()->address());
    $component->assertSee($transaction->recipient()->address());
    $component->assertSee(NumberFormatter::currency($transaction->fee(), Network::currency()));
    $component->assertSee(NumberFormatter::currency($transaction->amount(), Network::currency()));
});

it('should list received transactions (non-multi)', function () {
    $sent = Transaction::factory()->create([
        'sender_public_key' => $this->subject->public_key,
    ]);

    $received = Transaction::factory()->create([
        'recipient_id' => $this->subject->address,
    ]);

    $component = Livewire::test(WalletTransactionTable::class, [$this->subject->address, false, $this->subject->public_key]);
    $component->set('state.direction', 'received');

    foreach (ViewModelFactory::collection(collect([$received])) as $transaction) {
        $component->assertSee($transaction->id());
        $component->assertSee($transaction->timestamp());
        $component->assertSee($transaction->sender()->address());
        $component->assertSee($transaction->recipient()->address());
        $component->assertSee(NumberFormatter::currency($transaction->fee(), Network::currency()));
        $component->assertSee(NumberFormatter::currency($transaction->amount(), Network::currency()));
    }

    foreach (ViewModelFactory::collection(collect([$sent])) as $transaction) {
        $component->assertDontSee($transaction->id());
    }
});

it('should list received transactions (multi)', function () {
    $sent = Transaction::factory()->create([
        'sender_public_key' => $this->subject->public_key,
    ]);

    $received = Transaction::factory()->create([
        'asset' => [
            'payments' => [
                [
                    'amount'      => '100000000',
                    'recipientId' => $this->subject->address,
                ],
            ],
        ],
    ]);

    $component = Livewire::test(WalletTransactionTable::class, [$this->subject->address, false, $this->subject->public_key]);
    $component->set('state.direction', 'received');

    foreach (ViewModelFactory::collection(collect([$received])) as $transaction) {
        $component->assertSee($transaction->id());
        $component->assertSee($transaction->timestamp());
        $component->assertSee($transaction->sender()->address());
        $component->assertSee($transaction->recipient()->address());
        $component->assertSee(NumberFormatter::currency($transaction->fee(), Network::currency()));
        $component->assertSee(NumberFormatter::currency($transaction->amount(), Network::currency()));
    }

    foreach (ViewModelFactory::collection(collect([$sent])) as $transaction) {
        $component->assertDontSee($transaction->id());
    }
});

it('should list sent transactions', function () {
    $sent = Transaction::factory()->create([
        'sender_public_key' => $this->subject->public_key,
    ]);

    $received = Transaction::factory()->create([
        'recipient_id' => $this->subject->address,
    ]);

    $component = Livewire::test(WalletTransactionTable::class, [$this->subject->address, false, $this->subject->public_key]);
    $component->set('state.direction', 'sent');

    foreach (ViewModelFactory::collection(collect([$sent])) as $transaction) {
        $component->assertSee($transaction->id());
        $component->assertSee($transaction->timestamp());
        $component->assertSee($transaction->sender()->address());
        $component->assertSee($transaction->recipient()->address());
        $component->assertSee(NumberFormatter::currency($transaction->fee(), Network::currency()));
        $component->assertSee(NumberFormatter::currency($transaction->amount(), Network::currency()));
    }

    foreach (ViewModelFactory::collection(collect([$received])) as $transaction) {
        $component->assertDontSee($transaction->id());
    }
});

it('should apply filters', function () {
    $block = Block::factory()->create();

    $component = Livewire::test(WalletTransactionTable::class, [$this->subject->address, false, $this->subject->public_key]);

    $notExpected = Transaction::factory(10)->create([
        'id'                => (string) Uuid::uuid4(),
        'block_id'          => $block->id,
        'type'              => TransactionTypeGroupEnum::CORE,
        'type_group'        => CoreTransactionTypeEnum::TRANSFER,
        'sender_public_key' => $this->subject->public_key,
        'recipient_id'      => $this->subject->address,
        'timestamp'         => 112982056,
        'fee'               => 1e8,
        'amount'            => 1e8,
    ]);

    foreach (ViewModelFactory::collection($notExpected) as $transaction) {
        $component->assertDontSee($transaction->id());
        $component->assertDontSee($transaction->timestamp());
        $component->assertDontSee($transaction->sender()->address());
        $component->assertDontSee($transaction->recipient()->address());
        $component->assertDontSee(NumberFormatter::currency($transaction->fee(), Network::currency()));
        $component->assertDontSee(NumberFormatter::currency($transaction->amount(), Network::currency()));
    }

    $expected = Transaction::factory(10)->create([
        'sender_public_key' => $this->subject->public_key,
        'type_group'        => TransactionTypeGroupEnum::CORE,
        'type'              => CoreTransactionTypeEnum::VOTE,
    ]);

    $component->set('state.type', 'vote');

    foreach (ViewModelFactory::collection($expected) as $transaction) {
        $component->assertSee($transaction->id());
        $component->assertSee($transaction->timestamp());
        $component->assertSee($transaction->sender()->address());
        $component->assertSee($transaction->recipient()->address());
        $component->assertSee(NumberFormatter::currency($transaction->fee(), Network::currency()));
        $component->assertSee(NumberFormatter::currency($transaction->amount(), Network::currency()));
    }
});

it('should reset the pagination when state changes', function () {
    $component = Livewire::test(WalletTransactionTable::class, [$this->subject->address, false, $this->subject->public_key]);

    $component->set('page', 3);
    $component->assertSet('page', 3);

    $component->set('state.type', 'vote');
    $component->assertSet('page', 1);

    $component->set('page', 3);
    $component->assertSet('page', 3);

    $component->set('state.direction', 'sent');
    $component->assertSet('page', 1);
});

it('should apply filters through an event', function () {
    $block = Block::factory()->create();

    $component = Livewire::test(WalletTransactionTable::class, [$this->subject->address, false, $this->subject->public_key]);

    $notExpected = Transaction::factory(10)->create([
        'id'                => (string) Uuid::uuid4(),
        'block_id'          => $block->id,
        'type'              => TransactionTypeGroupEnum::CORE,
        'type_group'        => CoreTransactionTypeEnum::TRANSFER,
        'sender_public_key' => $this->subject->public_key,
        'recipient_id'      => $this->subject->address,
        'timestamp'         => 112982056,
        'fee'               => 1e8,
        'amount'            => 1e8,
    ]);

    foreach (ViewModelFactory::collection($notExpected) as $transaction) {
        $component->assertDontSee($transaction->id());
        $component->assertDontSee($transaction->timestamp());
        $component->assertDontSee($transaction->sender()->address());
        $component->assertDontSee($transaction->recipient()->address());
        $component->assertDontSee(NumberFormatter::currency($transaction->fee(), Network::currency()));
        $component->assertDontSee(NumberFormatter::currency($transaction->amount(), Network::currency()));
    }

    $expected = Transaction::factory(10)->create([
        'sender_public_key' => $this->subject->public_key,
        'type_group'        => TransactionTypeGroupEnum::CORE,
        'type'              => CoreTransactionTypeEnum::VOTE,
    ]);

    $component->set('state.type', 'vote');

    foreach (ViewModelFactory::collection($expected) as $transaction) {
        $component->assertSee($transaction->id());
        $component->assertSee($transaction->timestamp());
        $component->assertSee($transaction->sender()->address());
        $component->assertSee($transaction->recipient()->address());
        $component->assertSee(NumberFormatter::currency($transaction->fee(), Network::currency()));
        $component->assertSee(NumberFormatter::currency($transaction->amount(), Network::currency()));
    }
});

it('should apply directions through an event', function () {
    $sent = Transaction::factory()->transfer()->create([
        'sender_public_key' => $this->subject->public_key,
    ]);

    $received = Transaction::factory()->create([
        'sender_public_key' => Wallet::factory()->create()->public_key,
        'recipient_id'      => $this->subject->address,
    ]);

    $component = Livewire::test(WalletTransactionTable::class, [$this->subject->address, false, $this->subject->public_key]);

    $component->emit('filterTransactionsByDirection', 'all');

    foreach (ViewModelFactory::collection(collect([$sent, $received])) as $transaction) {
        $component->assertSee($transaction->id());
        $component->assertSee($transaction->timestamp());
        $component->assertSee($transaction->sender()->address());
        $component->assertSee($transaction->recipient()->address());
        $component->assertSee(NumberFormatter::currency($transaction->fee(), Network::currency()));
        $component->assertSee(NumberFormatter::currency($transaction->amount(), Network::currency()));
    }

    $component->emit('filterTransactionsByDirection', 'received');

    $component->assertSee($received->id);
    $component->assertDontSee($sent->id);

    $component->emit('filterTransactionsByDirection', 'sent');

    $component->assertDontSee($received->id);
    $component->assertSee($sent->id);

    $component->emit('filterTransactionsByDirection', 'all');

    $component->assertSee($received->id);
    $component->assertSee($sent->id);
});


it('should update the records fiat tooltip when currency changed', function () {
    Config::set('explorer.networks.development.canBeExchanged', true);

    (new CryptoCompareCache())->setPrices('USD', collect([
        '2020-10-19' => 24210,
    ]));

    (new CryptoCompareCache())->setPrices('BTC', collect([
        '2020-10-19' => 0.1234567,
    ]));

    Transaction::factory()->create([
        'sender_public_key' => $this->subject->public_key,
        'timestamp'         => 112982056,
        'amount'            => 499 * 1e8,
    ]);

    $component = Livewire::test(WalletTransactionTable::class, [$this->subject->address, false, $this->subject->public_key]);

    $component->assertSeeHtml('data-tippy-content="12,080,790 USD"');
    $component->assertDontSeeHtml('data-tippy-content="61.6048933 BTC"');

    $settings = Settings::all();
    $settings['currency'] = 'BTC';
    Session::put('settings', json_encode($settings));

    $component->emit('currencyChanged', 'BTC');

    $component->assertDontSeeHtml('data-tippy-content="12,080,790 USD"');
    $component->assertSeeHtml('data-tippy-content="61.6048933 BTC"');
});
