<?php

declare(strict_types=1);

use App\Models\Block;
use App\Models\Transaction;
use App\Models\Wallet;
use App\ViewModels\TransactionViewModel;
use function Tests\configureExplorerDatabase;
use function Tests\transactionTypeSchemas;

beforeEach(function () {
    configureExplorerDatabase();

    $this->block = Block::factory()->create(['height' => 1]);
    Block::factory()->create(['height' => 5000000]);

    $this->subject = new TransactionViewModel(Transaction::factory()->create([
        'block_id'          => $this->block->id,
        'fee'               => 1 * 1e8,
        'amount'            => 2 * 1e8,
        'sender_public_key' => Wallet::factory()->create(['address' => 'sender'])->public_key,
        'recipient_id'      => Wallet::factory()->create(['address' => 'recipient'])->address,
    ]));
});

it('should get the url', function () {
    expect($this->subject->url())->toBeString();
    expect($this->subject->url())->toBe(route('transaction', $this->subject->id()));
});

it('should determine if the transaction is incoming', function () {
    expect($this->subject->isReceived('recipient'))->toBeTrue();
    expect($this->subject->isReceived('sender'))->toBeFalse();
});

it('should determine if the transaction is outgoing', function () {
    expect($this->subject->isSent('sender'))->toBeTrue();
    expect($this->subject->isSent('recipient'))->toBeFalse();
});

it('should get the timestamp', function () {
    expect($this->subject->timestamp())->toBeString();
    expect($this->subject->timestamp())->toBe('19 Oct 2020 (04:54:16)');
});

it('should get the block ID', function () {
    expect($this->subject->blockId())->toBeString();
    expect($this->subject->blockId())->toBe($this->block->id);
});

it('should get the fee', function () {
    expect($this->subject->fee())->toBeString();
    expect($this->subject->fee())->toBe('ARK 1.00');
});

it('should get the amount', function () {
    expect($this->subject->amount())->toBeString();
    expect($this->subject->amount())->toBe('ARK 2.00');
});

it('should get the confirmations', function () {
    expect($this->subject->confirmations())->toBeString();
    expect($this->subject->confirmations())->toBe('4,999,999');
});

it('should determine if the transaction is confirmed', function () {
    expect($this->subject->isConfirmed())->toBeTrue();
});

it('should determine the transaction type', function (string $method, int $type, int $typeGroup, array $asset) {
    $subject = new TransactionViewModel(Transaction::factory()->create([
        'type'       => $type,
        'type_group' => $typeGroup,
        'asset'      => $asset,
    ]));

    expect($subject->$method())->toBeTrue();

    $subject = new TransactionViewModel(Transaction::factory()->create([
        'type'       => 666,
        'type_group' => 666,
        'asset'      => $asset,
    ]));

    expect($subject->$method())->toBeFalse();
})->with(transactionTypeSchemas());
