<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Contracts\SettingsStorage;
use App\Facades\Network;
use App\Services\Cache\NetworkStatusBlockCache;
use App\Services\NumberFormatter;
use Illuminate\View\View;
use Livewire\Component;

final class PriceTicker extends Component
{
    /** @phpstan-ignore-next-line */
    protected $listeners = [
        'currencyChanged' => 'setValues',
    ];

    public string $price;

    public string $from;

    public string $to;

    public bool $isAvailable = false;

    public function mount(): void
    {
        $this->setValues();
    }

    public function setValues(): void
    {
        $this->isAvailable = (new NetworkStatusBlockCache())->getIsAvailable(Network::currency(), app(SettingsStorage::class)->currency());
        $this->price       = $this->getPriceFormatted();
        $this->from        = Network::currency();
        $this->to          = app(SettingsStorage::class)->currency();
    }

    private function getPriceFormatted(): string
    {
        $price = (new NetworkStatusBlockCache())->getPrice(Network::currency(), app(SettingsStorage::class)->currency());

        if ($price === null) {
            return '';
        }

        return NumberFormatter::currencyWithDecimalsWithoutSuffix($price, app(SettingsStorage::class)->currency());
    }

    public function render(): View
    {
        return view('livewire.price-ticker', [
            'from'  => $this->from,
            'to'    => $this->to,
            'price' => $this->price,
        ]);
    }
}
