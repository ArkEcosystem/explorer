<?php

declare(strict_types=1);

namespace App\Http\Livewire\Stats;

use App\Enums\StatsPeriods;
use App\Http\Livewire\Concerns\AvailablePeriods;
use App\Models\Transaction;
use App\Services\NumberFormatter;
use App\Services\Settings;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Component;

final class InsightAllTimeTransactions extends Component
{
    use AvailablePeriods;

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
            'allTimeTransactionsValue' => $this->allTimeTransactions(),
            'transactionsTitle'        => trans('pages.statistics.insights.transactions'),
            'transactionsValue'        => $this->countTransactionsPerPeriod($this->period),
            'chartValues'              => $this->chartValues($this->period),
            'chartTheme'               => $this->chartTheme(),
            'options'                  => $this->availablePeriods(),
            'refreshInterval'          => $this->refreshInterval,
        ]);
    }

    private function allTimeTransactions(): string
    {
        $value = $this->transactionsPerPeriod(StatsPeriods::ALL);

        return NumberFormatter::number($value->sum());
    }

    private function countTransactionsPerPeriod(string $period): string
    {
        $value = $this->transactionsPerPeriod($period);

        return NumberFormatter::number($value->sum());
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
            ->select(DB::raw("to_char(to_timestamp(timestamp), 'yyyy-mm-dd') as period, COUNT('id') as transactions"))
            ->when($from, fn ($query) => $query->whereRaw("to_char(to_timestamp(timestamp), 'yyyy-mm-dd') > ?", [$from]))
            ->latest('period')
            ->groupBy('period')
            ->pluck('transactions')
        );
    }
}
