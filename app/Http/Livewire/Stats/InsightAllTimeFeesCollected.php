<?php

declare(strict_types=1);

namespace App\Http\Livewire\Stats;

use App\Enums\StatsPeriods;
use App\Facades\Network;
use App\Http\Livewire\Concerns\AvailablePeriods;
use App\Models\Transaction;
use App\Services\NumberFormatter;
use App\Services\Settings;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
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
        $fees = $this->transactionsPerPeriod(StatsPeriods::ALL);

        return NumberFormatter::currency($fees->sum(), Network::currency());
    }

    private function fees(string $period): string
    {
        $fees = $this->transactionsPerPeriod($period);

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
        $from = $this->getRangeFromPeriod($period);

        $cacheKey = collect([__CLASS__, 'transactions-per-period', $period, $from])->filter()->join('.');

        return Cache::remember($cacheKey, (int) $this->refreshInterval, fn () => Transaction::query()
                ->select(DB::raw("to_char(to_timestamp(timestamp), 'yyyy-mm-dd') as period, SUM(fee /1e8) as fees"))
                ->when($from, fn ($query) => $query->whereRaw("to_char(to_timestamp(timestamp), 'yyyy-mm-dd') > ?", [$from]))
                ->latest('period')
                ->groupBy('period')
                ->pluck('fees')
        );
    }
}
