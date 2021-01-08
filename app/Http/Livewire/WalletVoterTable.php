<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Http\Livewire\Concerns\WalletsOrdering;
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
    use WalletsOrdering;

    /** @phpstan-ignore-next-line */
    protected $listeners = [
        'orderWalletsBy',
    ];

    public string $publicKey;

    public string $username;

    public function mount(string $publicKey, string $username): void
    {
        $this->publicKey = $publicKey;
        $this->username  = $username;
    }

    public function render(): View
    {
        /** @phpstan-ignore-next-line */
        $query = Wallet::where('attributes->vote', $this->publicKey)->scoped($this->getOrderingScope(), $this->state['walletsOrderingDirection']);

        return view('livewire.wallet-table', [
            'wallets' => ViewModelFactory::paginate($query->paginate()),
        ]);
    }
}
