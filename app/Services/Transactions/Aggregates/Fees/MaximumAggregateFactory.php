<?php

declare(strict_types=1);

namespace App\Services\Transactions\Aggregates\Fees;

use App\Services\Transactions\Aggregates\Fees\Maximum\AllAggregate;
use App\Services\Transactions\Aggregates\Fees\Maximum\DayAggregate;
use App\Services\Transactions\Aggregates\Fees\Maximum\MonthAggregate;
use App\Services\Transactions\Aggregates\Fees\Maximum\QuarterAggregate;
use App\Services\Transactions\Aggregates\Fees\Maximum\WeekAggregate;
use App\Services\Transactions\Aggregates\Fees\Maximum\YearAggregate;
use InvalidArgumentException;

final class MaximumAggregateFactory
{
    /**
     * @return DayAggregate|WeekAggregate|MonthAggregate|QuarterAggregate|YearAggregate|AllAggregate
     */
    public static function make(string $period, ?string $type = null)
    {
        if ($period === 'day') {
            return new DayAggregate();
        }

        if ($period === 'week') {
            return new WeekAggregate();
        }

        if ($period === 'month') {
            return new MonthAggregate();
        }

        if ($period === 'quarter') {
            return new QuarterAggregate();
        }

        if ($period === 'year') {
            return new YearAggregate();
        }

        if ($period === 'all') {
            return new AllAggregate($type);
        }

        throw new InvalidArgumentException('Invalid aggregate period.');
    }
}
