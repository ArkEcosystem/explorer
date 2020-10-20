<?php

declare(strict_types=1);

use App\Models\Transaction;
use App\Services\Transactions\TransactionType;
use function Tests\configureExplorerDatabase;
use function Tests\transactionTypeSchemas;

beforeEach(fn () => configureExplorerDatabase());

it('should determine the icon that matches the type', function (string $method, int $type, int $typeGroup, array $asset) {
    $transaction = Transaction::factory()->create([
        'type'       => $type,
        'type_group' => $typeGroup,
        'asset'      => $asset,
    ]);

    expect((new TransactionType($transaction))->$method())->toBeTrue();
})->with(transactionTypeSchemas());
