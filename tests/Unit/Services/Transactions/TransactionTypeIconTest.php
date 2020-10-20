<?php

declare(strict_types=1);

use App\Models\Transaction;
use App\Services\Transactions\TransactionTypeIcon;
use Illuminate\Support\Str;
use function Tests\configureExplorerDatabase;
use function Tests\transactionTypeSchemas;

beforeEach(fn () => configureExplorerDatabase());

it('should determine the icon that matches the type', function (string $method, int $type, int $typeGroup, array $asset) {
    $transaction = Transaction::factory()->create([
        'type'       => $type,
        'type_group' => $typeGroup,
        'asset'      => $asset,
    ]);

    expect((new TransactionTypeIcon($transaction))->name())->toBe(str_replace('_', '-', Str::snake(substr($method, 2))));
})->with(transactionTypeSchemas());
