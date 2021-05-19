<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Models\Wallet;
use App\ViewModels\WalletViewModel;
use Illuminate\View\View;
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
        return new WalletViewModel($this->wallet);
    }

    public function render(): View
    {
        return view('livewire.wallet-balance', [
            'balance' => $this->getWalletView()->balanceFiat(),
        ]);
    }
}
