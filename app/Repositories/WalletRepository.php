<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\WalletRepository as Contract;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

final class WalletRepository implements Contract
{
    public function allWithUsername(): Builder
    {
        return Wallet::whereNotNull('attributes->delegate->username')->orderBy('balance');
    }

    public function allWithVote(): Builder
    {
        return Wallet::whereNotNull('attributes->vote')->orderBy('balance');
    }

    public function allWithPublicKey(): Builder
    {
        return Wallet::whereNotNull('public_key');
    }

    public function allWithMultiSignature(): Builder
    {
        return Wallet::whereNotNull('attributes->multiSignature');
    }

    public function findByAddress(string $address): Wallet
    {
        return Wallet::where('address', $address)->firstOrFail();
    }

    public function findByPublicKey(string $publicKey): Wallet
    {
        return Wallet::where('public_key', $publicKey)->firstOrFail();
    }

    public function findByPublicKeys(array $publicKeys): Collection
    {
        return Wallet::whereIn('public_key', $publicKeys)->get();
    }

    public function findByUsername(string $username): Wallet
    {
        return Wallet::where('attributes->delegate->username', $username)->firstOrFail();
    }

    public function findByIdentifier(string $identifier): Wallet
    {
        return Wallet::query()
            ->where('address', $identifier)
            ->orWhere('public_key', $identifier)
            ->orWhere('attributes->delegate->username', $identifier)
            ->firstOrFail();
    }
}
