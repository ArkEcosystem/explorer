<?php

declare(strict_types=1);

namespace App\Contracts;

use Illuminate\Support\Collection;

interface TransactionRepository
{
    public function allByWallet(string $address, string $publicKey): Collection;

    public function allBySender(string $publicKey): Collection;

    public function allByRecipient(string $address): Collection;
}
