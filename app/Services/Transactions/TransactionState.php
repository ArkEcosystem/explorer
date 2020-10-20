<?php

declare(strict_types=1);

namespace App\Services\Transactions;

use App\Facades\Network;
use App\Models\Transaction;
use App\Services\Blockchain\NetworkStatus;

final class TransactionState
{
    private Transaction $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function isConfirmed(): bool
    {
        $confirmations = NetworkStatus::height() - $this->transaction->block->height;

        return $confirmations >= Network::confirmations();
    }

    public function isSent(string $address): bool
    {
        return $this->transaction->sender->address === $address;
    }

    public function isReceived(string $address): bool
    {
        return $this->transaction->recipient->address === $address;
    }
}
