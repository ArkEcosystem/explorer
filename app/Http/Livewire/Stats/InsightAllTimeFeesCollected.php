<?php

declare(strict_types=1);

namespace App\Http\Livewire\Stats;

use App\Enums\StatsPeriods;
use App\Facades\Network;
use App\Http\Livewire\Concerns\AvailablePeriods;
use App\Http\Livewire\Concerns\ChartNumberFormatters;
use App\Http\Livewire\Concerns\StatisticsChart;
use App\Services\Cache\FeeCache;
use Illuminate\View\View;
use Livewire\Component;

final class InsightAllTimeFeesCollected extends Component
{
    use AvailablePeriods;
    use ChartNumberFormatters;
    use StatisticsChart;

    private const CHART_COLOR = 'yellow';

    public string $period = '';

    private string $refreshInterval = '';

    /** @phpstan-ignore-next-line */
    protected $listeners = ['toggleDarkMode' => '$refresh'];

    public function mount(): void
    {
        $this->refreshInterval = (string) config('explorer.statistics.refreshInterval', '60');
        $this->period          = $this->defaultPeriod();
    }

    public function render(): View
    {
        return view('livewire.stats.insight-all-time-fees-collected', [
            'allTimeFeesCollectedTitle' => trans('pages.statistics.insights.all-time-fees-collected'),
            'allTimeFeesCollectedValue' => $this->asMoney($this->totalTransactionsPerPeriod(FeeCache::class, StatsPeriods::ALL)),
            'feesTitle'                 => trans('pages.statistics.insights.fees'),
            'feesValue'                 => $this->asNumber($this->totalTransactionsPerPeriod(FeeCache::class, $this->period)).' '.Network::currency(),
            'feesTooltip'               => $this->asMoney($this->totalTransactionsPerPeriod(FeeCache::class, $this->period)),
            'chartValues'               => $this->chartValues(FeeCache::class, $this->period),
            'chartTheme'                => $this->chartTheme(),
            'options'                   => $this->availablePeriods(),
            'refreshInterval'           => $this->refreshInterval,
        ]);
    }
}
