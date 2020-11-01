<?php

declare(strict_types=1);

use App\Models\Transaction;
use App\Repositories\TransactionRepository;
use Illuminate\Support\Collection;

beforeEach(fn () => $this->subject = new TransactionRepository());

it('should find all transactions by wallet', function () {
    $wallet = Transaction::factory(10)->create()[0]->sender;

    expect($this->subject->allByWallet($wallet->address, $wallet->public_key))->toBeInstanceOf(Collection::class);
});

it('should find all transactions by sender', function () {
    $wallet = Transaction::factory(10)->create()[0]->sender;

    expect($this->subject->allBySender($wallet->public_key))->toBeInstanceOf(Collection::class);
});

it('should find all transactions by recipient', function () {
    $wallet = Transaction::factory(10)->create()[0]->recipient;

    expect($this->subject->allByRecipient($wallet->address))->toBeInstanceOf(Collection::class);
});
