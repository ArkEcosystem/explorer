<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Facades\Network;
use App\Services\CryptoCompare;
use App\Services\Settings;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;
use App\Services\NumberFormatter;
use Konceiver\BetterNumberFormatter\BetterNumberFormatter;

final class PriceStats extends Component
{
    /** @phpstan-ignore-next-line */
    protected $listeners = ['currencyChanged' => '$refresh'];

    public function render(): View
    {
        return view('livewire.price-stats', [
            'price'       => $this->getPriceFormatted(),
            'from'        => Network::currency(),
            'to'          => Settings::currency(),
            'priceChange' => $this->getPriceChange(),
            'historical'  => $this->getHistorical(),
        ]);
    }

    private function getPriceChange(): ?float
    {
        if (! Network::canBeExchanged()) {
            return null;
        }

        $priceFullRange = CryptoCompare::historicalHourly(Network::currency(), Settings::currency(), 24);

        $initialPrice = (float) $priceFullRange->first();
        $finalPrice   = (float) $priceFullRange->last();

        if ($initialPrice === 0.0 || $finalPrice === 0.0) {
            return  0;
        }

        return ($finalPrice / $initialPrice) - 1;
    }

    private function getPriceFormatted(): string
    {
        $currency = Settings::currency();
        $price    = CryptoCompare::price(Network::currency(), $currency);

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

    private function getHistorical(): Collection
    {
        if (! Network::canBeExchanged()) {
            return collect([4, 5, 2, 2, 2, 3, 5, 1, 4, 5, 6, 5, 3, 3, 4, 5, 6, 4, 4, 4, 5, 8, 8, 10]);
        }

        return CryptoCompare::historicalHourly(Network::currency(), Settings::currency());
    }
}
