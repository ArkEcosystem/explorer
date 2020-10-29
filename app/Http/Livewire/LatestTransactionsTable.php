<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Facades\Network;
use App\Http\Livewire\Concerns\ManagesTransactionTypeScopes;
use App\Models\Transaction;
use App\ViewModels\ViewModelFactory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
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
    }

    public function render(): View
    {
        return view('livewire.latest-transactions-table', [
            'transactions' => ViewModelFactory::collection($this->transactions),
        ]);
    }

    public function pollTransactions(): void
    {
        $this->transactions = Cache::remember('latestTransactionsTable:'.$this->state['type'], Network::blockTime(), function () {
            // $query = Transaction::latestByTimestamp();
            $query = Transaction::orderBy('timestamp', 'asc');

            if ($this->state['type'] !== 'all') {
                $scopeClass = $this->scopes[$this->state['type']];

                /* @var \Illuminate\Database\Eloquent\Model */
                $query = $query->withScope($scopeClass);
            }

            return $query->take(15)->get();
        });
    }
}
