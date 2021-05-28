<?php

declare(strict_types=1);

namespace App\Http\Livewire\Stats;

use App\Facades\Network;
use App\Http\Livewire\Concerns\AvailablePeriods;
use App\Services\NumberFormatter;
use Illuminate\View\View;
use Livewire\Component;

class InsightCurrentAverageFee extends Component
{
    use AvailablePeriods;

    public string $period = 'week';

    private string $currency = '';

    private string $refreshInterval = '';

    public function mount(): void
    {
        $this->currency        = Network::currency();
        $this->refreshInterval = (string) config('explorer.statistics.refreshInterval', '60');
    }

    public function render(): View
    {
        return view('livewire.stats.insight-current-average-fee', [
            'currentAverageFeeTitle' => trans('pages.statistics.insights.current-average-fee'),
            'currentAverageFeeValue' => $this->currentAverageFee(),
            'minFeeTitle' => trans('pages.statistics.insights.min-fee'),
            'minFeeValue' => $this->minFee($this->period),
            'maxFeeTitle' => trans('pages.statistics.insights.max-fee'),
            'maxFeeValue' => $this->maxFee($this->period),
            'options' => $this->availablePeriods(),
        ]);
    }

    private function currentAverageFee(): string
    {
        return NumberFormatter::currency(0.36350066, $this->currency);
    }

    private function minFee(string $period): string
    {
        return NumberFormatter::currency(0.36350066, $this->currency);
    }

    private function maxFee(string $period): string
    {
        return NumberFormatter::currency(0.36350066, $this->currency);
    }
}
