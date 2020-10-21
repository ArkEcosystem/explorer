<?php

namespace App\Http\Livewire;

use App\Models\Wallet;
use App\ViewModels\ViewModelFactory;
use ARKEcosystem\UserInterface\Http\Livewire\Concerns\HasPagination;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class TopWalletsTable extends Component
{
    use HasPagination;

    public function render(): View
    {
        return view('livewire.wallets-by-balance-table', [
            'wallets' => ViewModelFactory::paginate(Wallet::wealthy()->paginate()),
        ]);
    }
}
