<?php

declare(strict_types=1);

namespace App\Http\Livewire\Stats;

use App\Facades\Network;
use App\Http\Livewire\Concerns\AvailablePeriods;
use App\Services\NumberFormatter;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

class InsightAllTimeFeesCollected extends Component
{
    use AvailablePeriods;

    public string $period = 'week';

    private string $chartColor = 'yellow';

    private string $currency = '';

    private string $refreshInterval = '';

    public function mount(): void
    {
        $this->currency        = Network::currency();
        $this->refreshInterval = (string) config('explorer.statistics.refreshInterval', '60');
    }

    public function render(): View
    {
        return view('livewire.stats.insight-all-time-fees-collected', [
            'allTimeFeesCollectedTitle' => trans('pages.statistics.insights.all-time-fees-collected'),
            'allTimeFeesCollectedValue' => $this->allTimeFeesCollected(),
            'feesTitle' => trans('pages.statistics.insights.fees'),
            'feesValue' => $this->fees($this->period),
            'chartValues' => $this->chartValues($this->period),
            'chartColor' => $this->chartColor,
            'options' => $this->availablePeriods(),
        ]);
    }

    private function allTimeFeesCollected(): string
    {
        return NumberFormatter::currency(344643.07368944, $this->currency);
    }

    private function fees(string $period): string
    {
        return NumberFormatter::currency(344643.07368944, $this->currency);
    }

    private function chartValues(string $period): Collection
    {
        return collect([4, 5, 2, 2, 2, 3, 5, 1, 4, 5, 6, 5, 3, 3, 4, 5, 6, 4, 4, 4, 5, 8, 8, 10]);
    }
}
