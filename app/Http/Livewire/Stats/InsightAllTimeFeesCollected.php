<?php

declare(strict_types=1);

namespace App\Http\Livewire\Stats;

use App\Enums\StatsPeriods;
use App\Facades\Network;
use App\Http\Livewire\Concerns\AvailablePeriods;
use App\Services\Cache\FeeCache;
use App\Services\NumberFormatter;
use App\Services\Settings;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

final class InsightAllTimeFeesCollected extends Component
{
    use AvailablePeriods;

    private const CHART_COLOR = 'yellow';

    public string $period = '';

    private string $refreshInterval = '';

    public function mount(): void
    {
        $this->refreshInterval = (string) config('explorer.statistics.refreshInterval', '60');
        $this->period          = $this->defaultPeriod();
    }

    public function render(): View
    {
        return view('livewire.stats.insight-all-time-fees-collected', [
            'allTimeFeesCollectedTitle' => trans('pages.statistics.insights.all-time-fees-collected'),
            'allTimeFeesCollectedValue' => $this->allTimeFeesCollected(),
            'feesTitle'                 => trans('pages.statistics.insights.fees'),
            'feesValue'                 => $this->fees($this->period),
            'chartValues'               => $this->chartValues($this->period),
            'chartTheme'                => $this->chartTheme(),
            'options'                   => $this->availablePeriods(),
            'refreshInterval'           => $this->refreshInterval,
        ]);
    }

    private function allTimeFeesCollected(): string
    {
        $fees = collect($this->transactionsPerPeriod(StatsPeriods::ALL)->get('datasets'));

        return NumberFormatter::currency($fees->sum(), Network::currency());
    }

    private function fees(string $period): string
    {
        $fees = collect($this->transactionsPerPeriod($period)->get('datasets'));

        return NumberFormatter::currency($fees->sum(), Network::currency());
    }

    private function chartValues(string $period): Collection
    {
        return $this->transactionsPerPeriod($period);
    }

    private function chartTheme(): Collection
    {
        $mode = Settings::usesDarkTheme() ? 'dark' : 'light';

        return collect(['name' => self::CHART_COLOR, 'mode' => $mode]);
    }

    private function transactionsPerPeriod(string $period): Collection
    {
        return collect((new FeeCache)->getHistorical($period));
    }
}
