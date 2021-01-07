<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Models\Scopes\OrderByAddressScope;
use App\Models\Scopes\OrderByBalanceScope;
use App\Models\Wallet;
use App\ViewModels\ViewModelFactory;
use ARKEcosystem\UserInterface\Http\Livewire\Concerns\HasPagination;
use Illuminate\View\View;
use Livewire\Component;

final class WalletVoterTable extends Component
{
    use HasPagination;

    /** @phpstan-ignore-next-line */
    protected $listeners = [
        'orderWalletsBy',
    ];

    public string $publicKey;

    public string $username;

    public array $state = [
        'walletsOrdering'          => 'balance',
        'walletsOrderingDirection' => 'desc',
    ];

    public function orderWalletsBy(string $value): void
    {
        $this->state['walletsOrdering'] = $value;

        $this->state['walletsOrderingDirection'] = $this->state['walletsOrderingDirection'] === 'desc' ? 'asc' : 'desc';

        $this->gotoPage(1);
    }

    public function mount(string $publicKey, string $username): void
    {
        $this->publicKey = $publicKey;
        $this->username  = $username;
    }

    public function render(): View
    {
        $query = Wallet::where('attributes->vote', $this->publicKey)->scoped($this->getOrderingScope(), $this->state['walletsOrderingDirection']);

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
