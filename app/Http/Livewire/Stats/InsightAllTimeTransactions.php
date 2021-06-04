<?php

declare(strict_types=1);

namespace App\Http\Livewire\Stats;

use App\Enums\StatsPeriods;
use App\Http\Livewire\Concerns\AvailablePeriods;
use App\Services\Cache\TransactionCache;
use App\Services\NumberFormatter;
use App\Services\Settings;
use Illuminate\Support\Collection;
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
        $transactions = collect($this->transactionsPerPeriod(StatsPeriods::ALL)->get('datasets'));

        return NumberFormatter::number($transactions->sum());
    }

    private function countTransactionsPerPeriod(string $period): string
    {
        $transactions = collect($this->transactionsPerPeriod($period)->get('datasets'));

        return NumberFormatter::number($transactions->sum());
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
        return collect((new TransactionCache())->getHistorical($period));
    }
}
