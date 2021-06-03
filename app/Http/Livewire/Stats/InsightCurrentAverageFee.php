<?php

declare(strict_types=1);

namespace App\Http\Livewire\Stats;

use App\Facades\Network;
use App\Http\Livewire\Concerns\AvailablePeriods;
use App\Models\Transaction;
use App\Services\NumberFormatter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Component;

final class InsightCurrentAverageFee extends Component
{
    use AvailablePeriods;

    private const PERIOD_CURRENT = 'current';

    public string $period = '';

    private string $refreshInterval = '';

    public function mount(): void
    {
        $this->refreshInterval = (string) config('explorer.statistics.refreshInterval', '60');
        $this->period          = $this->defaultPeriod();
    }

    public function render(): View
    {
        return view('livewire.stats.insight-current-average-fee', [
            'currentAverageFeeTitle' => trans('pages.statistics.insights.current-average-fee'),
            'currentAverageFeeValue' => $this->currentAverageFee(),
            'minFeeTitle'            => trans('pages.statistics.insights.min-fee'),
            'minFeeValue'            => $this->minFee($this->period),
            'maxFeeTitle'            => trans('pages.statistics.insights.max-fee'),
            'maxFeeValue'            => $this->maxFee($this->period),
            'options'                => $this->availablePeriods(),
            'refreshInterval'        => $this->refreshInterval,
        ]);
    }

    private function currentAverageFee(): string
    {
        $value = $this->getFeesAggregatesPerPeriod(self::PERIOD_CURRENT);

        return NumberFormatter::currency(data_get($value, 'average', 0), Network::currency());
    }

    private function minFee(string $period): string
    {
        $value = $this->getFeesAggregatesPerPeriod($period);

        return NumberFormatter::currency(data_get($value, 'minimum', 0), Network::currency());
    }

    private function maxFee(string $period): string
    {
        $value = $this->getFeesAggregatesPerPeriod($period);

        return NumberFormatter::currency(data_get($value, 'maximum', 0), Network::currency());
    }

    private function getFeesAggregatesPerPeriod(string $period): Model | null
    {
        $cacheKey = __CLASS__.".fee-aggregates-per-period.{$period}";

        $from = $this->getRangeFromPeriod($period);

        if ($period !== self::PERIOD_CURRENT) {
            $cacheKey .= ".{$from}";
        }

        return Cache::remember($cacheKey, (int) $this->refreshInterval, fn () => Transaction::query()
                ->select(DB::raw("to_char(to_timestamp(timestamp), 'yyyy-mm-dd') as period, AVG(fee / 1e8) as average, MIN(fee / 1e8) as minimum, MAX(fee / 1e8) as maximum"))
                ->when($period === self::PERIOD_CURRENT, function ($query): void {
                    $now = Carbon::createFromTimestamp((int) Carbon::now()->timestamp - $this->getArkEpoch())->toDateString();
                    $query->whereRaw("to_char(to_timestamp(timestamp), 'yyyy-mm-dd') = ?", [$now]);
                }, function ($query) use ($from): void {
                    $query->whereRaw("to_char(to_timestamp(timestamp), 'yyyy-mm-dd') > ?", [$from]);
                })
                ->groupBy('period')
                ->first()
        );
    }
}
