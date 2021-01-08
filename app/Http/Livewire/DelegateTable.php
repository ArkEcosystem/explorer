<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Facades\Network;
use App\Models\Scopes\OrderByAddressScope;
use App\Models\Scopes\OrderByIdScope;
use App\Models\Scopes\OrderByRankScope;
use App\Models\Scopes\OrderByVoteScope;
use App\Models\Wallet;
use App\ViewModels\ViewModelFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Component;

final class DelegateTable extends Component
{
    public array $state = [
        'status'                     => 'active',
        'delegatesOrdering'          => 'rank',
        'delegatesOrderingDirection' => 'asc',
    ];

    /** @phpstan-ignore-next-line */
    protected $listeners = [
        'filterByDelegateStatus',
        'orderDelegatesBy',
    ];

    public function orderDelegatesBy(string $value): void
    {
        $this->state['delegatesOrdering'] = $value;

        $this->state['delegatesOrderingDirection'] = $this->state['delegatesOrderingDirection'] === 'desc' ? 'asc' : 'desc';
    }

    public function mount(): void
    {
        $this->state = array_merge([
            'status'                     => 'active',
            'delegatesOrdering'          => 'rank',
            'delegatesOrderingDirection' => 'asc',
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
            //->orderByRaw("(\"attributes\"->'delegate'->>'rank')::numeric ASC")
            ->scoped($this->getOrderingScope(), $this->state['delegatesOrderingDirection']);
    }

    public function standbyQuery(): Builder
    {
        return Wallet::query()
            ->whereNotNull('attributes->delegate->username')
            ->whereRaw("(\"attributes\"->'delegate'->>'rank')::numeric > ?", [Network::delegateCount()])
            //->orderByRaw("(\"attributes\"->'delegate'->>'rank')::numeric ASC")
            ->limit(Network::delegateCount())
            ->scoped($this->getOrderingScope(), $this->state['delegatesOrderingDirection']);
    }

    public function resignedQuery(): Builder
    {
        return Wallet::query()
            ->whereNotNull('attributes->delegate->username')
            ->where('attributes->delegate->resigned', true)
            ->limit(Network::delegateCount())
            ->scoped($this->getOrderingScope(), $this->state['delegatesOrderingDirection']);
    }

    private function getOrderingScope(): string
    {
        $scopes = [
            'id'      => OrderByIdScope::class,
            'rank'    => OrderByRankScope::class,
            'address' => OrderByAddressScope::class,
            'votes'   => OrderByVoteScope::class,
        ];

        return $scopes[$this->state['delegatesOrdering']];
    }
}
