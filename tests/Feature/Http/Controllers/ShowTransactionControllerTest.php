<?php

declare(strict_types=1);

use App\Models\Transaction;

use function Tests\configureExplorerDatabase;

it('should render the page without any errors', function () {
    configureExplorerDatabase();

    $this->withoutExceptionHandling();

    $this
        ->get(route('transaction', Transaction::factory()->create()))
        ->assertNoContent();
});
