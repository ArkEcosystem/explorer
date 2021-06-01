<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Facades\Network;
use App\Models\Wallet;
use App\ViewModels\ViewModelFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

final class DelegateTable extends Component
{
    use WithPagination;

    public array $state = [
        'status' => 'active',
    ];

    /** @phpstan-ignore-next-line */
    protected $listeners = ['filterByDelegateStatus'];

    public function render(): View
    {
        if ($this->state['status'] === 'resigned') {
            $delegates = $this->resignedQuery()->paginate(Network::delegateCount());
        } elseif ($this->state['status'] === 'standby') {
            $delegates = $this->standbyQuery()->paginate(Network::delegateCount());
        } else {
            $delegates = $this->activeQuery()->get();
        }

        return view('livewire.delegate-table', [
            'delegates' => $this->state['status'] === 'active' ? ViewModelFactory::collection($delegates) : ViewModelFactory::paginate($delegates),
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
            ->orderByRaw("(\"attributes\"->'delegate'->>'rank')::numeric ASC");
    }

    public function standbyQuery(): Builder
    {
        return Wallet::query()
            ->whereNotNull('attributes->delegate->username')
            ->whereRaw("(\"attributes\"->'delegate'->>'rank')::numeric > ?", [Network::delegateCount()])
            ->orderByRaw("(\"attributes\"->'delegate'->>'rank')::numeric ASC");
    }

    public function resignedQuery(): Builder
    {
        return Wallet::query()
            ->whereNotNull('attributes->delegate->username')
            ->where('attributes->delegate->resigned', true);
    }
}
