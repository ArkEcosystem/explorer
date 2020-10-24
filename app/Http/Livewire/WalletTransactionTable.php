<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Http\Livewire\Concerns\ManagesTransactionTypeScopes;
use App\Models\Transaction;
use App\Models\Wallet;
use App\ViewModels\ViewModelFactory;
use ARKEcosystem\UserInterface\Http\Livewire\Concerns\HasPagination;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Component;

final class WalletTransactionTable extends Component
{
    use HasPagination;
    use ManagesTransactionTypeScopes;

    public array $state = [
        'type'      => 'all',
        'direction' => 'all',
    ];

    /** @phpstan-ignore-next-line */
    protected $listeners = [
        'filterTransactionsByDirection',
        'filterTransactionsByType',
    ];

    public Wallet $wallet;

    public function mount(Wallet $wallet): void
    {
        $this->wallet = $wallet;
    }

    public function filterTransactionsByDirection(string $value): void
    {
        $this->state['direction'] = $value;
    }

    public function filterTransactionsByType(string $value): void
    {
        $this->state['type'] = $value;
    }

    public function render(): View
    {
        // if ($this->state['type'] !== 'all') {
        //     Transaction::addGlobalScope(resolve($this->scopes[$this->state['type']]));
        // }

        if ($this->state['direction'] === 'all') {
            $query = $this->getAllQuery();
        }

        if ($this->state['direction'] === 'received') {
            $query = $this->getReceivedQuery();
        }

        if ($this->state['direction'] === 'sent') {
            $query = $this->getSentQuery();
        }

        return view('livewire.wallet-transaction-table', [
            'transactions'      => ViewModelFactory::paginate($query->latestByTimestamp()->paginate()),
            'countAll'          => $this->getAllQuery()->count(),
            'countReceived'     => $this->getReceivedQuery()->count(),
            'countSent'         => $this->getSentQuery()->count(),
        ]);
    }

    private function getAllQuery(): Builder
    {
        return Transaction::query()
            ->where('sender_public_key', $this->wallet->public_key)
            ->orWhere('recipient_id', $this->wallet->address);
    }

    private function getReceivedQuery(): Builder
    {
        return Transaction::query()
            ->where('recipient_id', $this->wallet->address);
        // ->orWhereJsonContains('asset->payments->recipientId', $this->wallet->address);
    }

    private function getSentQuery(): Builder
    {
        return Transaction::where('sender_public_key', $this->wallet->public_key);
    }
}
