<?php

declare(strict_types=1);

namespace App\Services\Transactions;

use App\Models\Transaction;
use App\Services\Transactions\Concerns\ManagesTransactionTypes;

final class TransactionTypeIcon
{
    use ManagesTransactionTypes;

    private TransactionType $type;

    public function __construct(Transaction $transaction)
    {
        $this->type = new TransactionType($transaction);
    }

    public function name(): string
    {
        foreach ($this->typesExact as $method => $icon) {
            if ($this->type->$method()) {
                return $icon;
            }
        }

        return 'unknown';
    }
}
