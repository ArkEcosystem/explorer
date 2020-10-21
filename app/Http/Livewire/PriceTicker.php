<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use Livewire\Component;
use App\Facades\Network;
use Illuminate\View\View;
use App\Services\Settings;
use App\Services\CryptoCompare;

final class PriceTicker extends Component
{
    public function render(): View
    {
        return view('livewire.price-ticker', [
            'from'  => Network::currency(),
            'to'    => Settings::currency(),
            'price' => CryptoCompare::price(Network::currency(), Settings::currency()),
        ]);
    }
}
