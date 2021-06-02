<?php

declare(strict_types=1);

namespace App\Http\Livewire\Concerns;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

trait AvailablePeriods
{
    private function defaultPeriod(): string
    {
        return 'week';
    }

    private function availablePeriods(): array
    {
        return [
            'day'      => trans('forms.statistics.day'),
            'week'     => trans('forms.statistics.week'),
            'month'    => trans('forms.statistics.month'),
            'quarter'  => trans('forms.statistics.quarter'),
            'year'     => trans('forms.statistics.year'),
            'all'      => trans('forms.statistics.all'),
        ];
    }

    private function subtractFromPeriod(string $period): string
    {
        return collect([
            'day'     => '1 day',
            'week'    => '1 week',
            'month'   => '1 month',
            'quarter' => '1 quarter',
            'year'    => '1 year',
            'all'     => '100 years',
        ])->get($period);
    }

    private function getRangeFromPeriod(string $period): string | null
    {
        if (! collect($this->availablePeriods())->keys()->containsStrict(Str::lower($period))) {
            return null;
        }

        return Carbon::createFromTimestamp(Carbon::now()->unix() - $this->getArkEpoch())
            ->sub($this->subtractFromPeriod($period))
            ->toDateString();
    }

    private function getRangeFromPeriodWithoutArkEpoch(string $period): string | null
    {
        if (! collect($this->availablePeriods())->keys()->containsStrict(Str::lower($period))) {
            return null;
        }

        return Carbon::now()->sub($this->subtractFromPeriod($period))->toDateString();
    }

    private function getArkEpoch(): int
    {
        return 1490101200;
    }
}
