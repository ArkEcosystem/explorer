<?php

declare(strict_types=1);

namespace App\Http\Livewire\Concerns;

use App\Models\Scopes\OrderByAmountScope;
use App\Models\Scopes\OrderByFeeScope;
use App\Models\Scopes\OrderByIdScope;
use App\Models\Scopes\OrderByRecipientScope;
use App\Models\Scopes\OrderBySenderScope;
use App\Models\Scopes\OrderByTimestampScope;

trait TransactionsOrdering
{
    public string $transactionsOrdering          = 'timestamp';

    public string $transactionsOrderingDirection = 'desc';

    public function orderTransactionsBy(string $value): void
    {
        $this->transactionsOrdering = $value;

        $this->transactionsOrderingDirection = $this->transactionsOrderingDirection === 'desc' ? 'asc' : 'desc';
    }

    private function getOrderingScope(): string
    {
        $scopes = [
            'id'        => OrderByIdScope::class,
            'timestamp' => OrderByTimestampScope::class,
            'sender'    => OrderBySenderScope::class,
            'recipient' => OrderByRecipientScope::class,
            'amount'    => OrderByAmountScope::class,
            'fee'       => OrderByFeeScope::class,
        ];

        return $scopes[$this->transactionsOrdering];
    }
}
