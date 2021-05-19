<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Models\Wallet;
use App\ViewModels\ViewModelFactory;
use Livewire\Component;

final class WalletBalance extends Component
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
            'balance' => $this->getWalletView()->balanceFiat(),
        ]);
    }
}
