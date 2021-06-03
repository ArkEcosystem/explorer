<?php

declare(strict_types=1);

namespace App\Http\Livewire\Stats;

use App\Facades\Network;
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

final class InsightAllTimeFeesCollected extends Component
{
    use AvailablePeriods;

    private const PERIOD_ALL_TIME = 'all-time';

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
        $value = $this->transactionsPerPeriod(self::PERIOD_ALL_TIME);

        return NumberFormatter::currency((string) $value, Network::currency());
    }

    private function fees(string $period): string
    {
        /** @var Transaction $value */
        $value = $this->transactionsPerPeriod($period);

        return NumberFormatter::currency($value->pluck('fees')->sum(), Network::currency());
    }

    private function chartValues(string $period): Collection
    {
        /** @var Transaction $value */
        $value = $this->transactionsPerPeriod($period);

        return collect($value->pluck('fees'));
    }

    private function chartTheme(): Collection
    {
        $mode = Settings::usesDarkTheme() ? 'dark' : 'light';

        return collect(['name' => self::CHART_COLOR, 'mode' => $mode]);
    }

    private function transactionsPerPeriod(string $period): EloquentCollection | float
    {
        $cacheKey = __CLASS__.".transactions-per-period.{$period}";

        if ($period === self::PERIOD_ALL_TIME) {
            return Cache::remember($cacheKey, (int) $this->refreshInterval, function (): float {
                $value = Transaction::select(DB::raw('sum(fee / 1e8) as fees'))->first();

                return (float) data_get($value, 'fees', '0');
            });
        }

        $from = $this->getRangeFromPeriod($period);
        $cacheKey .= ".{$from }";

        return Cache::remember($cacheKey, (int) $this->refreshInterval, fn () => Transaction::query()
                ->select(DB::raw("to_char(to_timestamp(timestamp), 'yyyy-mm-dd') as period, SUM(fee /1e8) as fees"))
                ->when($period !== self::PERIOD_ALL_TIME, function ($query) use ($from): void {
                    $query->whereRaw("to_char(to_timestamp(timestamp), 'yyyy-mm-dd') > ?", [$from]);
                })
                ->latest('period')
                ->groupBy('period')
                ->get()
        );
    }
}
