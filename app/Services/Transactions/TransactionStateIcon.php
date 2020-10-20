<?php

declare(strict_types=1);

namespace App\Services\Transactions;

use App\Models\Transaction;

final class TransactionStateIcon
{
    private TransactionState $state;

    public function __construct(Transaction $transaction)
    {
        $this->state = new TransactionState($transaction);
    }

    public function name(string $address): string
    {
        if ($this->state->isConfirmed()) {
            return 'confirmed';
        }

        if ($this->state->isSent($address)) {
            return 'sent';
        }

        if ($this->state->isReceived($address)) {
            return 'received';
        }

        return 'unknown';
    }
}
