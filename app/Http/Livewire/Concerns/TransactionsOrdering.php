<?php

declare(strict_types=1);

namespace App\Http\Livewire\Concerns;

use App\Enums\OrderingDirectionEnum;
use App\Enums\OrderingTypeEnum;
use App\Models\Scopes\OrderByAmountAscScope;
use App\Models\Scopes\OrderByAmountDescScope;
use App\Models\Scopes\OrderByFeeAscScope;
use App\Models\Scopes\OrderByFeeDescScope;
use App\Models\Scopes\OrderByIdAscScope;
use App\Models\Scopes\OrderByIdDescScope;
use App\Models\Scopes\OrderByRecipientAscScope;
use App\Models\Scopes\OrderByRecipientDescScope;
use App\Models\Scopes\OrderBySenderAscScope;
use App\Models\Scopes\OrderBySenderDescScope;
use App\Models\Scopes\OrderByTimestampAscScope;
use App\Models\Scopes\OrderByTimestampDescScope;

trait TransactionsOrdering
{
    public string $transactionsOrdering          = OrderingTypeEnum::TIMESTAMP;

    public string $transactionsOrderingDirection = OrderingDirectionEnum::DESC;

    public function orderTransactionsBy(string $value): void
    {
        if ($value === $this->transactionsOrdering) {
            if ($this->transactionsOrderingDirection === OrderingDirectionEnum::DESC) {
                $this->transactionsOrderingDirection = OrderingDirectionEnum::ASC;
            } else {
                $this->transactionsOrderingDirection = OrderingDirectionEnum::DESC;
            }
        }

        $this->transactionsOrdering = $value;
    }

    public function renderDirectionIcon(string $value): string
    {
        $value = substr($value, ((int) strrpos($value, '.')) + 1);

        if ($value === $this->transactionsOrdering) {
            if ($this->transactionsOrderingDirection === OrderingDirectionEnum::DESC) {
                return 'chevron-down';
            }

            return 'chevron-up';
        }

        return 'chevron-down';
    }

    private function getOrderingScope(): string
    {
        $scopes = [
            'id'        => ['asc' => OrderByIdAscScope::class, 'desc' => OrderByIdDescScope::class],
            'timestamp' => ['asc' => OrderByTimestampAscScope::class, 'desc' => OrderByTimestampDescScope::class],
            'sender'    => ['asc' => OrderBySenderAscScope::class, 'desc' => OrderBySenderDescScope::class],
            'recipient' => ['asc' => OrderByRecipientAscScope::class, 'desc' => OrderByRecipientDescScope::class],
            'amount'    => ['asc' => OrderByAmountAscScope::class, 'desc' => OrderByAmountDescScope::class],
            'fee'       => ['asc' => OrderByFeeAscScope::class, 'desc' => OrderByFeeDescScope::class],
        ];

        return $scopes[$this->transactionsOrdering][$this->transactionsOrderingDirection];
    }
}
