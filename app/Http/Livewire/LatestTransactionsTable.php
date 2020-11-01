<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Http\Livewire\Concerns\ManagesTransactionTypeScopes;
use App\Services\Cache\TableCache;
use App\ViewModels\ViewModelFactory;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

final class LatestTransactionsTable extends Component
{
    use ManagesTransactionTypeScopes;

    public array $state = [
        'type' => 'all',
    ];

    private Collection $transactions;

    /** @phpstan-ignore-next-line */
    protected $listeners = ['filterTransactionsByType'];

    public function mount(): void
    {
        $this->transactions = new Collection();
    }

    public function filterTransactionsByType(string $value): void
    {
        $this->state['type'] = $value;

        $this->pollTransactions();
    }

    public function render(): View
    {
        return view('livewire.latest-transactions-table', [
            'transactions' => ViewModelFactory::collection($this->transactions),
        ]);
    }

    public function pollTransactions(): void
    {
        $this->transactions = (new TableCache())->latestTransactions($this->state['type'], $this->scopes);
    }
}
