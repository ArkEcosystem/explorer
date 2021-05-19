<?php

namespace App\Http\Livewire;

use App\Models\Wallet;
use Livewire\Component;
use App\ViewModels\ViewModelFactory;

class WalletBalance extends Component
{
    public Wallet $wallet;

    public function mount(Wallet $wallet): void
    {
        $this->wallet = $wallet;
    }

    public function getWalletView()
    {
        return ViewModelFactory::make($this->wallet);
    }

    public function render()
    {
        return view('livewire.wallet-balance', [
            'balance' => $this->getWalletView()->balanceFiat()
        ]);
    }
}
