<?php

declare(strict_types=1);

use App\DTO\Payment;

use App\Models\Wallet;
use function Tests\configureExplorerDatabase;

it('should make an instance that has all properties', function () {
    configureExplorerDatabase();

    $subject = new Payment(123, [
        'amount'      => 1e8,
        'recipientId' => Wallet::factory()->create(['address' => 'DGs7JcNRXVAWqKMwceWkVwNWfg5pfth2Pm'])->address,
    ]);

    expect($subject->amount())->toBe(1.0);
    expect($subject->amountFiat())->toBe('0 USD');
    expect($subject->address())->toBe('DGs7JcNRXVAWqKMwceWkVwNWfg5pfth2Pm');
    expect($subject->username())->toBe('username');
    expect($subject->recipient())->toBeInstanceOf(Payment::class);
});
