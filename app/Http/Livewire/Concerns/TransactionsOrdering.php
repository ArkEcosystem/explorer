<?php

declare(strict_types=1);

namespace App\Http\Livewire\Concerns;

use App\Enums\OrderingDirectionEnum;
use App\Enums\OrderingTypeEnum;
use App\Models\Scopes\OrderByAmountAscScope;
use App\Models\Scopes\OrderByAmountDescScope;
use App\Models\Scopes\OrderByConfirmationAscScope;
use App\Models\Scopes\OrderByConfirmationDescScope;
use App\Models\Scopes\OrderByFeeAscScope;
use App\Models\Scopes\OrderByFeeDescScope;
use App\Models\Scopes\OrderByRecipientAscScope;
use App\Models\Scopes\OrderByRecipientDescScope;
use App\Models\Scopes\OrderBySenderAscScope;
use App\Models\Scopes\OrderBySenderDescScope;
use App\Models\Scopes\OrderByTimestampAscScope;
use App\Models\Scopes\OrderByTimestampDescScope;

trait TransactionsOrdering
{
    use Ordering;

    public string $ordering          = OrderingTypeEnum::TIMESTAMP;

    public string $orderingDirection = OrderingDirectionEnum::DESC;

    public function orderTransactionsBy(string $value): void
    {
        if ($value === $this->ordering) {
            if ($this->orderingDirection === OrderingDirectionEnum::DESC) {
                $this->orderingDirection = OrderingDirectionEnum::ASC;
            } else {
                $this->orderingDirection = OrderingDirectionEnum::DESC;
            }
        }

        $this->ordering = $value;
    }

    private function getOrderingScope(): string
    {
        $scopes = [
            'timestamp'     => ['asc' => OrderByTimestampAscScope::class, 'desc' => OrderByTimestampDescScope::class],
            'sender'        => ['asc' => OrderBySenderAscScope::class, 'desc' => OrderBySenderDescScope::class],
            'recipient'     => ['asc' => OrderByRecipientAscScope::class, 'desc' => OrderByRecipientDescScope::class],
            'amount'        => ['asc' => OrderByAmountAscScope::class, 'desc' => OrderByAmountDescScope::class],
            'fee'           => ['asc' => OrderByFeeAscScope::class, 'desc' => OrderByFeeDescScope::class],
            'confirmations' => ['asc' => OrderByConfirmationAscScope::class, 'desc' => OrderByConfirmationDescScope::class],
        ];

        return $scopes[$this->ordering][$this->orderingDirection];
    }
}
