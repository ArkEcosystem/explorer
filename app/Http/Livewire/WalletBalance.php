<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Models\Wallet;
use App\ViewModels\ViewModelFactory;
use App\ViewModels\WalletViewModel;
use Livewire\Component;

final class WalletBalance extends Component
{
    public Wallet $wallet;

    public function mount(Wallet $wallet): void
    {
        $this->wallet = $wallet;
    }

    public function getWalletView(): WalletViewModel
    {
        return ViewModelFactory::make($this->wallet);
    }

    public function render(): void
    {
        return view('livewire.wallet-balance', [
            'balance' => $this->getWalletView()->balanceFiat(),
        ]);
    }
}
