<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Facades\Network;
use App\Services\CryptoCompare;
use App\Services\Settings;
use Illuminate\View\View;
use Livewire\Component;

final class PriceStats extends Component
{
    public function render(): View
    {
        // $priceFullRange = Cache::get('fsdfgds', collect());

        // $priceFullRange->push(rand(10, 40));

        // Cache::put('fsdfgds', $priceFullRange);

        // $priceFullRange = $priceFullRange->splice(-23);
        $priceFullRange = CryptoCompare::historicalHourly(Network::currency(), Settings::currency(), 24);

        return view('livewire.price-stats', [
            'from'  => Network::currency(),
            'to'    => Settings::currency(),
            'price' => CryptoCompare::price(Network::currency(), Settings::currency()),
            'priceChange' => ($priceFullRange->last() / $priceFullRange->first()) - 1,
            'historical' => CryptoCompare::historicalHourly(Network::currency(), Settings::currency()),
        ]);
    }
}
