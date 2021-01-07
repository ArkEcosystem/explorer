<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Models\Scopes\OrderByAmountScope;
use App\Models\Scopes\OrderByFeeScope;
use App\Models\Scopes\OrderByIdScope;
use App\Models\Scopes\OrderByRecipientScope;
use App\Models\Scopes\OrderBySenderScope;
use App\Models\Scopes\OrderByTimestampScope;
use App\Models\Transaction;
use App\ViewModels\ViewModelFactory;
use ARKEcosystem\UserInterface\Http\Livewire\Concerns\HasPagination;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class TransactionTable extends Component
{
    use HasPagination;

    public array $state = [
        'type'                         => 'all',
        'transactionsOrdering'          => 'timestamp',
        'transactionsOrderingDirection' => 'desc',
    ];

    /** @phpstan-ignore-next-line */
    protected $listeners = [
        'filterTransactionsByType',
        'orderTransactionsBy',
    ];

    public function orderTransactionsBy(string $value): void
    {
        $this->state['transactionsOrdering'] = $value;

        $this->state['transactionsOrderingDirection'] = $this->state['transactionsOrderingDirection'] === 'desc' ? 'asc' : 'desc';

        $this->gotoPage(1);
    }

    public function filterTransactionsByType(string $value): void
    {
        $this->state['type'] = $value;

        $this->gotoPage(1);
    }

    public function mount(): void
    {
        $this->state = array_merge([
            'type'                         => 'all',
            'transactionsOrdering'          => 'timestamp',
            'transactionsOrderingDirection' => 'desc',
        ], request('state', []));
    }

    public function render(): View
    {
        /** @phpstan-ignore-next-line */
        $query = Transaction::scoped($this->getOrderingScope(), $this->state['transactionsOrderingDirection']);

        if ($this->state['type'] !== 'all') {
            $scopeClass = Transaction::TYPE_SCOPES[$this->state['type']];

            $query = $query->scoped($scopeClass);
        }

        return view('livewire.transaction-table', [
            'transactions' => ViewModelFactory::paginate($query->paginate()),
        ]);
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

        return $scopes[$this->state['transactionsOrdering']];
    }
}
