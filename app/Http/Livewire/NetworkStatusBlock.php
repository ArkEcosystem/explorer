<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Actions\CacheNetworkHeight;
use App\Actions\CacheNetworkSupply;
use App\Facades\Network;
use App\Services\Cache\NetworkStatusBlockCache;
use App\Services\MarketCap;
use App\Services\NumberFormatter;
use App\Services\Settings;
use Illuminate\View\View;
use Konceiver\BetterNumberFormatter\BetterNumberFormatter;
use Livewire\Component;

final class NetworkStatusBlock extends Component
{
    /** @phpstan-ignore-next-line */
    protected $listeners = [
        'currencyChanged' => '$refresh',
        'updatePrice'     => '$refresh',
    ];

    public function render(): View
    {
        return view('livewire.network-status-block', [
            'price'       => $this->getPriceFormatted(),
            'priceChange' => $this->getPriceChange(),
            'height'      => CacheNetworkHeight::execute(),
            'network'     => Network::name(),
            'supply'      => CacheNetworkSupply::execute() / 1e8,
            'marketCap'   => MarketCap::getFormatted(Network::currency(), Settings::currency()),
        ]);
    }

    private function getPriceChange(): ?float
    {
        return (new NetworkStatusBlockCache())->getPriceChange(Network::currency(), Settings::currency());
    }

    private function getPriceFormatted(): ? string
    {
        $currency = Settings::currency();
        $price    = (new NetworkStatusBlockCache())->getPrice(Network::currency(), $currency);

        if ($price === null) {
            return null;
        }

        if (NumberFormatter::isFiat($currency)) {
            return BetterNumberFormatter::new()
                ->withLocale(Settings::locale())
                ->formatWithCurrencyAccounting($price);
        }

        return BetterNumberFormatter::new()
            ->formatWithCurrencyCustom(
                $price,
                $currency,
                NumberFormatter::CRYPTO_DECIMALS
            );
    }
}
