<?php

declare(strict_types=1);

namespace App\Http\Livewire\Stats;

use App\Enums\CryptoCurrencies;
use App\Facades\Network;
use App\Http\Livewire\Concerns\AvailablePeriods;
use App\Services\CryptoCompare;
use App\Services\NumberFormatter as ServiceNumberFormatter;
use App\Services\Settings;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Konceiver\BetterNumberFormatter\BetterNumberFormatter;
use Livewire\Component;

final class Chart extends Component
{
    use AvailablePeriods;

    public bool $show = true;

    public string $period = 'week';

    private string $refreshInterval = '';

    public function mount(): void
    {
        $this->refreshInterval = (string) config('explorer.statistics.refreshInterval', '60');
        $this->period          = $this->defaultPeriod();
        $this->show            = Network::canBeExchanged();
    }

    public function render(): View
    {
        return view('livewire.stats.chart', [
            'mainValue'           => $this->mainValueBTC(),
            'mainValueFiat'       => $this->mainValueFiat(),
            'mainValuePercentage' => $this->mainValuePercentage(),
            'mainValueVariation'  => $this->mainValueVariation(),
            'marketCapValue'      => $this->marketCap(),
            'minPriceValue'       => $this->minPrice(),
            'maxPriceValue'       => $this->maxPrice(),
            'chartDatasets'       => $this->chart($this->period)->get('datasets')->values(),
            'chartLabels'         => $this->chart($this->period)->get('labels')->values(),
            'chartTheme'          => $this->chartTheme(),
            'options'             => $this->availablePeriods(),
            'refreshInterval'     => $this->refreshInterval,
        ]);
    }

    public function updatedPeriod()
    {
        $this->dispatchBrowserEvent('stats-period-updated', []);
    }

    private function mainValueBTC(): string
    {
        $value = CryptoCompare::price(Network::currency(), CryptoCurrencies::BTC);

        return ServiceNumberFormatter::currency($value, CryptoCurrencies::BTC, 8);
    }

    private function mainValueFiat(): string
    {
        $value = CryptoCompare::price(Network::currency(), Settings::currency());

        return BetterNumberFormatter::new()->formatWithCurrency($value);
    }

    private function mainValuePercentage(): float
    {
        return abs($this->getDiffFromHistoricalHourly()) * 100;
    }

    private function mainValueVariation(): string
    {
        return $this->getDiffFromHistoricalHourly() < 0 ? 'down' : 'up';
    }

    private function getDiffFromHistoricalHourly(): float
    {
        $fullRange = $this->getHistoricalHourly(Settings::currency());

        $initial = (float) $fullRange->first();
        $final   = (float) $fullRange->last();

        if ($initial === 0.0 || $final === 0.0) {
            return  0;
        }

        return ($final / $initial) - 1;
    }

    private function marketCap(): string
    {
        $value = CryptoCompare::marketCap(Network::currency(), Settings::currency());

        return BetterNumberFormatter::new()->formatWithCurrency($value);
    }

    private function getPriceRange(): Collection
    {
        return $this->getHistoricalHourly(CryptoCurrencies::BTC);
    }

    private function minPrice(): string
    {
        $range = $this->getPriceRange();

        return ServiceNumberFormatter::currency((float) $range->min(), CryptoCurrencies::BTC, 8);
    }

    private function maxPrice(): string
    {
        $range = $this->getPriceRange();

        return ServiceNumberFormatter::currency((float) $range->max(), CryptoCurrencies::BTC, 8);
    }

    private function getHistoricalHourly(string $target): Collection
    {
        return CryptoCompare::historicalHourly(Network::currency(), $target, 24);
    }

    private function chart(string $period): Collection
    {
        $fiat   = CryptoCompare::historical(Network::currency(), Settings::currency());
        $crypto = CryptoCompare::historical(Network::currency(), CryptoCurrencies::BTC);

        if ($period !== 'all') {
            $from = $this->getRangeFromPeriodWithoutArkEpoch($period);

            $fiat   = $fiat->filter(fn ($value, $key) => Carbon::parse($key)->greaterThanOrEqualTo($from));
            $crypto = $crypto->filter(fn ($value, $key) => Carbon::parse($key)->greaterThanOrEqualTo($from));
        }

        $scaleFactor = 1000;

        return collect([
            'labels'   => $fiat->keys(),
            'datasets' => collect([
                ['type' => 'line', 'name' => Settings::currency(), 'data' => $fiat->values()],
                ['type' => 'bar', 'name' => CryptoCurrencies::BTC, 'data' => $crypto->values()->map(fn ($item) => ((float) ServiceNumberFormatter::currency($item, '', 8) * $scaleFactor)), 'scale' => $scaleFactor],
            ]),
        ]);
    }

    private function chartTheme(): Collection
    {
        $mode = Settings::usesDarkTheme() ? 'dark' : 'light';
        $name = $this->getDiffFromHistoricalHourly() > 0 ? 'green' : 'red';

        return collect(['name' => $name, 'mode' => $mode]);
    }
}
