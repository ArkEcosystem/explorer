<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Http\Livewire\Concerns\ManagesTransactionTypeScopes;
use App\Http\Livewire\Concerns\PerformsInitialLoad;
use App\Models\Transaction;
use App\ViewModels\ViewModelFactory;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Livewire\Component;

final class LatestTransactionsTable extends Component
{
    use ManagesTransactionTypeScopes;
    use PerformsInitialLoad;

    public array $state = [
        'type' => 'all',
    ];

    /** @phpstan-ignore-next-line */
    protected $listeners = ['filterTransactionsByType', 'performedInitialLoad'];

    public function filterTransactionsByType(string $value): void
    {
        $this->state['type'] = $value;
    }

    public function render(): View
    {
        $transactions = Cache::remember('latestTransactionsTable:'.$this->state['type'], 8, function () {
            $query = Transaction::latestByTimestamp();

            if ($this->state['type'] !== 'all') {
                $scopeClass = $this->scopes[$this->state['type']];

                /* @var \Illuminate\Database\Eloquent\Model */
                $query = $query->withScope($scopeClass);
            }

            return $query->take(15)->get();
        });

        return view('livewire.latest-transactions-table', [
            'transactions' => ViewModelFactory::collection($transactions),
        ]);
    }
}
