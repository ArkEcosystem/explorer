<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Facades\Network;
use App\Services\CryptoCompare;
use App\Services\Settings;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

final class PriceStats extends Component
{
    public bool $placeholder = false;

    public function mount(bool $placeholder = false)
    {
        $this->placeholder = $placeholder;
    }

    public function render(): View
    {
        // $priceFullRange = Cache::get('fsdfgds', collect());

        // $priceFullRange->push(rand(10, 40));

        // Cache::put('fsdfgds', $priceFullRange);

        // $priceFullRange = $priceFullRange->splice(-23);

        return view('livewire.price-stats', [
            'from'        => Network::currency(),
            'to'          => Settings::currency(),
            'priceChange' => $this->getPriceChange(),
            'historical'  => $this->getHistorical(),
        ]);
    }

    private function getPriceChange(): ?float
    {
        if ($this->placeholder) {
            return null;
        }

        $priceFullRange = CryptoCompare::historicalHourly(Network::currency(), Settings::currency(), 24);

        $initialPrice = $priceFullRange->first();

        return $initialPrice === 0 ? 0 : ($priceFullRange->last() / $initialPrice) - 1;
    }

    private function getHistorical(): Collection
    {
        if ($this->placeholder) {
            return collect([
                4,
                5,
                2,
                2,
                2,
                3,
                5,
                1,
                4,
                5,
                6,
                5,
                3,
                3,
                4,
                5,
                6,
                4,
                4,
                4,
                5,
                8,
                8,
                10,
            ]);
        }

        return CryptoCompare::historicalHourly(Network::currency(), Settings::currency());
    }
}
