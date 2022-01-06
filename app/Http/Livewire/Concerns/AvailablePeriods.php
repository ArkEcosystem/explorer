<?php

declare(strict_types=1);

namespace App\Http\Livewire\Concerns;

use App\Enums\StatsPeriods;

trait AvailablePeriods
{
    private function defaultPeriod(): string
    {
        return StatsPeriods::WEEK->value;
    }

    private function availablePeriods(): array
    {
        return [
            StatsPeriods::DAY->value      => trans('forms.statistics.periods.day'),
            StatsPeriods::WEEK->value     => trans('forms.statistics.periods.week'),
            StatsPeriods::MONTH->value    => trans('forms.statistics.periods.month'),
            StatsPeriods::QUARTER->value  => trans('forms.statistics.periods.quarter'),
            StatsPeriods::YEAR->value     => trans('forms.statistics.periods.year'),
            StatsPeriods::ALL->value      => trans('forms.statistics.periods.all'),
        ];
    }
}
