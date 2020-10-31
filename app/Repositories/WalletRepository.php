<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Wallet;
use App\Repositories\Concerns\ManagesCache;

final class WalletRepository
{
    use ManagesCache;

    public function findByAddress(string $address): Wallet
    {
        return Wallet::where('address', $address)->firstOrFail();
    }

    public function findByPublicKey(string $publicKey): Wallet
    {
        return Wallet::where('public_key', $publicKey)->firstOrFail();
    }

    public function findByUsername(string $username): Wallet
    {
        return Wallet::where('attributes->delegate->username', $username)->firstOrFail();
    }
}
