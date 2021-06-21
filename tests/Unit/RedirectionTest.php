<?php

declare(strict_types=1);

use App\Models\Block;
use App\Models\Transaction;
use App\Models\Wallet;
use function Tests\configureExplorerDatabase;

beforeEach(fn () => configureExplorerDatabase());

it('redirects to the correct route', function ($model, $oldUrl, $newUrl): void {
    $model = $model::factory()->create();

    $this->get(sprintf('%s/%s', $oldUrl, $model->id))->assertRedirect(sprintf('%s/%s', $newUrl, $model->id));
})->with([
    [Transaction::class, 'transaction', 'transactions'],
    [Wallet::class, 'wallet', 'wallets'],
    [Block::class, 'block', 'blocks'],
]);
