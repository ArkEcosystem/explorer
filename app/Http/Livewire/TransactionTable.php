<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Http\Livewire\Concerns\TransactionsOrdering;
use App\Models\Transaction;
use App\ViewModels\ViewModelFactory;
use ARKEcosystem\UserInterface\Http\Livewire\Concerns\HasPagination;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class TransactionTable extends Component
{
    use HasPagination;
    use TransactionsOrdering;

    public array $state = [
        'type' => 'all',
    ];

    /** @phpstan-ignore-next-line */
    protected $listeners = [
        'filterTransactionsByType',
        'orderTransactionsBy',
    ];

    public function filterTransactionsByType(string $value): void
    {
        $this->state['type'] = $value;
        $this->gotoPage(1);
    }

    public function mount(): void
    {
        $this->state = array_merge([
            'type' => 'all',
        ], request('state', []));
    }

    public function render(): View
    {
        $query = Transaction::withScope($this->getOrderingScope(), $this->transactionsOrderingDirection);

        if ($this->state['type'] !== 'all') {
            $scopeClass = Transaction::TYPE_SCOPES[$this->state['type']];

            $query = $query->withScope($scopeClass);
        }

        return view('livewire.transaction-table', [
            'transactions' => ViewModelFactory::paginate($query->paginate()),
        ]);
    }
}
