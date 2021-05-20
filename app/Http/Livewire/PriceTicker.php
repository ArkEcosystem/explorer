<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Facades\Network;
use App\Services\CryptoCompare;
use App\Services\Settings;
use Illuminate\View\View;
use Konceiver\BetterNumberFormatter\BetterNumberFormatter;
use Livewire\Component;
use NumberFormatter;

final class PriceTicker extends Component
{
    public function render(): View
    {
        $price = number_format(CryptoCompare::price(Network::currency(), Settings::currency()), 2);

        return view('livewire.price-ticker', [
            'from'  => Network::currency(),
            'to'    => Settings::currency(),
            'price' => $price,
        ]);
    }
}
