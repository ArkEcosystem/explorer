<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\WalletRepository;
use App\Models\Wallet;
use Illuminate\Support\Facades\Cache;

final class WalletRepositoryWithCache implements WalletRepository
{
    private WalletRepository $wallets;

    public function __construct(WalletRepository $wallets)
    {
        $this->wallets = $wallets;
    }

    public function findByAddress(string $address): Wallet
    {
        return Cache::remember(
            "repository:findByAddress.{$address}",
            60,
            fn () => $this->wallets->findByAddress($address)
        );
    }

    public function findByPublicKey(string $publicKey): Wallet
    {
        return Cache::remember(
            "repository:findByPublicKey.{$publicKey}",
            60,
            fn () => $this->wallets->findByPublicKey($publicKey)
        );
    }

    public function findByUsername(string $username): Wallet
    {
        return Cache::remember(
            "repository:findByUsername.{$username}",
            60,
            fn () => $this->wallets->findByUsername($username)
        );
    }
}
