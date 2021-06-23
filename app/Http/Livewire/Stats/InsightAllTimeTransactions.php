<?php

declare(strict_types=1);

namespace App\Http\Livewire\Stats;

use App\Enums\StatsPeriods;
use App\Http\Livewire\Concerns\AvailablePeriods;
use App\Http\Livewire\Concerns\StatisticsChart;
use App\Services\Cache\TransactionCache;
use Illuminate\View\View;
use Livewire\Component;

final class InsightAllTimeTransactions extends Component
{
    use AvailablePeriods;
    use StatisticsChart;

    private const CHART_COLOR = 'black';

    public string $period = '';

    private string $refreshInterval = '';

    public function mount(): void
    {
        $this->refreshInterval = (string) config('explorer.statistics.refreshInterval', '60');
        $this->period          = $this->defaultPeriod();
    }

    public function render(): View
    {
        return view('livewire.stats.insight-all-time-transactions', [
            'allTimeTransactionsTitle' => trans('pages.statistics.insights.all-time-transactions'),
            'allTimeTransactionsValue' => $this->sum(TransactionCache::class, StatsPeriods::ALL, 'numeric'),
            'transactionsTitle'        => trans('pages.statistics.insights.transactions'),
            'transactionsValue'        => $this->sum(TransactionCache::class, $this->period, 'numeric'),
            'chartValues'              => $this->chartValues(TransactionCache::class, $this->period),
            'chartTheme'               => $this->chartTheme(),
            'options'                  => $this->availablePeriods(),
            'refreshInterval'          => $this->refreshInterval,
        ]);
    }
}
