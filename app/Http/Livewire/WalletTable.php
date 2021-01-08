<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Models\Scopes\OrderByAddressScope;
use App\Models\Scopes\OrderByBalanceScope;
use App\Models\Scopes\OrderByInfoScope;
use App\Models\Wallet;
use App\ViewModels\ViewModelFactory;
use ARKEcosystem\UserInterface\Http\Livewire\Concerns\HasPagination;
use Illuminate\View\View;
use Livewire\Component;

final class WalletTable extends Component
{
    use HasPagination;

    public array $state = [
        'walletsOrdering'          => 'balance',
        'walletsOrderingDirection' => 'desc',
    ];

    /** @phpstan-ignore-next-line */
    protected $listeners = [
        'orderWalletsBy',
    ];

    public function orderWalletsBy(string $value): void
    {
        $this->state['walletsOrdering'] = $value;

        $this->state['walletsOrderingDirection'] = $this->state['walletsOrderingDirection'] === 'desc' ? 'asc' : 'desc';

        $this->gotoPage(1);
    }

    public function mount(): void
    {
        $this->state = array_merge([
            'walletsOrdering'          => 'balance',
            'walletsOrderingDirection' => 'desc',
        ], request('state', []));
    }

    public function render(): View
    {
        /** @phpstan-ignore-next-line */
        $query = Wallet::scoped($this->getOrderingScope(), $this->state['walletsOrderingDirection']);

        return view('livewire.wallet-table', [
            'wallets' => ViewModelFactory::paginate($query->paginate()),
        ]);
    }

    private function getOrderingScope(): string
    {
        $scopes = [
            'address' => OrderByAddressScope::class,
            'balance' => OrderByBalanceScope::class,
            'supply'  => OrderByBalanceScope::class,
        ];

        return $scopes[$this->state['walletsOrdering']];
    }
}
