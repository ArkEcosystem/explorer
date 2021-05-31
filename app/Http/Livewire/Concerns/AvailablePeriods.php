<?php

declare(strict_types=1);

namespace App\Http\Livewire\Concerns;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

trait AvailablePeriods
{
    private function availablePeriods(): array
    {
        return [
            '0 day'   => trans('forms.statistics.day'),
            '1 week'  => trans('forms.statistics.week'),
            '1 month' => trans('forms.statistics.month'),
            '1 quarter'  => trans('forms.statistics.quarter'),
            '1 year'  => trans('forms.statistics.year'),
            '90 years'  => trans('forms.statistics.all'),
        ];
    }

    private function getRangeFromPeriod(string $period): string | null
    {
        if (! collect($this->availablePeriods())->keys()->containsStrict(Str::lower($period))) {
            return null;
        }

        $arkEpoch = 1490101200;

        return Carbon::createFromTimestamp((int) Carbon::now()->timestamp - $arkEpoch)->sub($period)->toDateString();
    }
}
