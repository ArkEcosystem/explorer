<?php

declare(strict_types=1);

use App\Models\Transaction;
use App\Services\Search\TransactionSearch;

use function Tests\configureExplorerDatabase;

beforeEach(fn () => configureExplorerDatabase());

it('should search for a transaction by id', function () {
    $transaction = Transaction::factory(10)->create()[0];

    $result = (new TransactionSearch())->search([
        'term' => $transaction->id,
    ]);

    expect($result->get())->toHaveCount(1);
});
