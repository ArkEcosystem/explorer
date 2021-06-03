<?php

declare(strict_types=1);

namespace App\Http\Livewire\Concerns;

use App\Enums\StatsPeriods;
use App\Facades\Network;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

trait AvailablePeriods
{
    private function defaultPeriod(): string
    {
        return StatsPeriods::WEEK;
    }

    private function availablePeriods(): array
    {
        return [
            StatsPeriods::DAY      => trans('forms.statistics.periods.day'),
            StatsPeriods::WEEK     => trans('forms.statistics.periods.week'),
            StatsPeriods::MONTH    => trans('forms.statistics.periods.month'),
            StatsPeriods::QUARTER  => trans('forms.statistics.periods.quarter'),
            StatsPeriods::YEAR     => trans('forms.statistics.periods.year'),
            StatsPeriods::ALL      => trans('forms.statistics.periods.all'),
        ];
    }

    private function subtractFromPeriod(string $period): string
    {
        return collect([
            StatsPeriods::DAY     => '1 day',
            StatsPeriods::WEEK    => '1 week',
            StatsPeriods::MONTH   => '1 month',
            StatsPeriods::QUARTER => '1 quarter',
            StatsPeriods::YEAR    => '1 year',
        ])->get($period);
    }

    private function getRangeFromPeriod(string $period): string | null
    {
        if ($period === StatsPeriods::ALL) {
            return null;
        }

        if (! collect($this->availablePeriods())->keys()->containsStrict(Str::lower($period))) {
            return null;
        }

        return Carbon::createFromTimestamp(Carbon::now()->unix() - $this->getArkEpoch())
            ->sub($this->subtractFromPeriod($period))
            ->toDateString();
    }

    private function getArkEpoch(): int
    {
        return Network::epoch()->unix();
    }
}
