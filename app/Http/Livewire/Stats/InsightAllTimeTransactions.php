<?php

declare(strict_types=1);

namespace App\Http\Livewire\Stats;

use App\Http\Livewire\Concerns\AvailablePeriods;
use App\Models\Transaction;
use App\Services\NumberFormatter;
use App\Services\Settings;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Component;

final class InsightAllTimeTransactions extends Component
{
    use AvailablePeriods;

    public string $period = 'week';

    private string $chartColor = 'black';

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
        $value = $this->transactionsPerPeriod('all-time');

        return NumberFormatter::number((string) $value);
    }

    private function countTransactionsPerPeriod(string $period): string
    {
        /** @var Transaction $value */
        $value = $this->transactionsPerPeriod($period);

        return NumberFormatter::number($value->pluck('transactions')->sum());
    }

    private function chartValues(string $period): Collection
    {
        /** @var Transaction $value */
        $value = $this->transactionsPerPeriod($period);

        return collect($value->pluck('transactions'));
    }

    private function chartTheme(): Collection
    {
        $mode = Settings::usesDarkTheme() ? 'dark' : 'light';

        return collect(['name' => $this->chartColor, 'mode' => $mode]);
    }

    private function transactionsPerPeriod(string $period): EloquentCollection | string
    {
        $cacheKey = __CLASS__.".transactions-per-period.{$period}";

        if ($period === 'all-time') {
            return Cache::remember($cacheKey, (int) $this->refreshInterval, fn () => (string) Transaction::count());
        }

        $from = $this->getRangeFromPeriod($period);
        $cacheKey .= ".{$from}";

        return Cache::remember($cacheKey, (int) $this->refreshInterval, fn () => Transaction::query()
                ->select(DB::raw("to_char(to_timestamp(timestamp), 'yyyy-mm-dd') as period, COUNT('id') as transactions"))
                ->whereRaw("to_char(to_timestamp(timestamp), 'yyyy-mm-dd') > ?", [$from])
                ->latest('period')
                ->groupBy('period')
                ->get()
        );
    }
}
