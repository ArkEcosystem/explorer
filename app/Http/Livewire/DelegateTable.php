<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Facades\Network;
use App\Http\Livewire\Concerns\DelegatesOrdering;
use App\Models\Wallet;
use App\ViewModels\ViewModelFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Component;

final class DelegateTable extends Component
{
    use DelegatesOrdering;

    public array $state = [
        'status' => 'active',
    ];

    /** @phpstan-ignore-next-line */
    protected $listeners = [
        'filterByDelegateStatus',
        'orderDelegatesBy',
    ];

    public function mount(): void
    {
        $this->state = array_merge([
            'status' => 'active',
        ], request('state', []));
    }

    public function render(): View
    {
        if ($this->state['status'] === 'resigned') {
            $delegates = $this->resignedQuery()->get();
        } elseif ($this->state['status'] === 'standby') {
            $delegates = $this->standbyQuery()->get();
        } else {
            $delegates = $this->activeQuery()->get();
        }

        return view('livewire.delegate-table', [
            'delegates' => ViewModelFactory::collection($delegates),
        ]);
    }

    public function filterByDelegateStatus(string $value): void
    {
        $this->state['status'] = $value;
    }

    public function activeQuery(): Builder
    {
        return Wallet::query()
            ->whereNotNull('attributes->delegate->username')
            ->whereRaw("(\"attributes\"->'delegate'->>'rank')::numeric <= ?", [Network::delegateCount()])
            ->scoped($this->getOrderingScope(), $this->delegatesOrderingDirection);
    }

    public function standbyQuery(): Builder
    {
        return Wallet::query()
            ->whereNotNull('attributes->delegate->username')
            ->whereRaw("(\"attributes\"->'delegate'->>'rank')::numeric > ?", [Network::delegateCount()])
            ->limit(Network::delegateCount())
            ->scoped($this->getOrderingScope(), $this->delegatesOrderingDirection);
    }

    public function resignedQuery(): Builder
    {
        return Wallet::query()
            ->whereNotNull('attributes->delegate->username')
            ->where('attributes->delegate->resigned', true)
            ->limit(Network::delegateCount())
            ->scoped($this->getOrderingScope(), $this->delegatesOrderingDirection);
    }
}
