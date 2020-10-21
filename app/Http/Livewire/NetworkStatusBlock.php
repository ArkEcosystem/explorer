<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use Livewire\Component;
use App\Facades\Network;
use Illuminate\View\View;
use App\Services\Settings;
use App\Services\CryptoCompare;
use App\Services\NumberFormatter;
use App\Services\Blockchain\NetworkStatus;

final class NetworkStatusBlock extends Component
{
    public function render(): View
    {
        $marketCap = 0;

        if (Network::canBeExchanged()) {
            $marketCap = NetworkStatus::supply() * CryptoCompare::price(Network::currency(), Settings::currency());
        }

        return view('livewire.network-status-block', [
            'height'    => NumberFormatter::number(NetworkStatus::height()),
            'network'   => Network::name(),
            'supply'    => NumberFormatter::currency(NetworkStatus::supply(), Network::currency()),
            'marketCap' => NumberFormatter::currency($marketCap, Settings::currency()),
        ]);
    }
}
