<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\TransactionRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

final class TransactionRepositoryWithCache implements TransactionRepository
{
    private TransactionRepository $transactions;

    public function __construct(TransactionRepository $transactions)
    {
        $this->transactions = $transactions;
    }

    public function allByWallet(string $address, string $publicKey): Collection
    {
        return Cache::remember(
            "repository:allByWallet.{$address}.{$publicKey}",
            60,
            fn () => $this->transactions->allByWallet($address, $publicKey)
        );
    }

    public function allBySender(string $publicKey): Collection
    {
        return Cache::remember(
            "repository:allBySender.{$publicKey}",
            60,
            fn () => $this->transactions->allBySender($publicKey)
        );
    }

    public function allByRecipient(string $address): Collection
    {
        return Cache::remember(
            "repository:allByRecipient.{$address}",
            60,
            fn () => $this->transactions->allByRecipient($address)
        );
    }
}
