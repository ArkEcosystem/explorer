<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Http\Livewire\Concerns\WalletsOrdering;
use App\Models\Wallet;
use App\ViewModels\ViewModelFactory;
use ARKEcosystem\UserInterface\Http\Livewire\Concerns\HasPagination;
use Illuminate\View\View;
use Livewire\Component;

final class WalletTable extends Component
{
    use HasPagination;
    use WalletsOrdering;

    /** @phpstan-ignore-next-line */
    protected $listeners = [
        'orderWalletsBy',
    ];

    public function render(): View
    {
        $query = Wallet::scoped($this->getOrderingScope(), $this->walletsOrderingDirection);

        return view('livewire.wallet-table', [
            'wallets' => ViewModelFactory::paginate($query->paginate()),
        ]);
    }
}
