<?php

declare(strict_types=1);

use App\Models\Wallet;
use App\Services\Search\WalletSearch;

use function Tests\configureExplorerDatabase;

beforeEach(fn () => configureExplorerDatabase());

it('should search for a wallet by address', function () {
    $wallet = Wallet::factory(10)->create()[0];

    $result = (new WalletSearch())->search([
        'term' => $wallet->address,
    ]);

    expect($result->get())->toHaveCount(1);
});

it('should search for a wallet by public_key', function () {
    $wallet = Wallet::factory(10)->create()[0];

    $result = (new WalletSearch())->search([
        'term' => $wallet->public_key,
    ]);

    expect($result->get())->toHaveCount(1);
});

it('should search for a wallet by username', function () {
    $wallet = Wallet::factory(10)->create()[0];

    $result = (new WalletSearch())->search([
        'username' => $wallet->username,
    ]);

    expect($result->get())->toHaveCount(1);
});

it('should search for a wallet by vote', function () {
    $wallet = Wallet::factory(10)->create()[0];

    $result = (new WalletSearch())->search([
        'vote' => $wallet->vote,
    ]);

    expect($result->get())->toHaveCount(1);
});
