<?php

declare(strict_types=1);

namespace App\Services\Transactions\Aggregates\Fees;

use App\Services\Transactions\Aggregates\Fees\Minimum\DayAggregate;
use App\Services\Transactions\Aggregates\Fees\Minimum\LastAggregate;
use App\Services\Transactions\Aggregates\Fees\Minimum\MonthAggregate;
use App\Services\Transactions\Aggregates\Fees\Minimum\QuarterAggregate;
use App\Services\Transactions\Aggregates\Fees\Minimum\WeekAggregate;
use App\Services\Transactions\Aggregates\Fees\Minimum\YearAggregate;
use InvalidArgumentException;

final class MinimumAggregateFactory
{
    /**
     * @return DayAggregate|WeekAggregate|MonthAggregate|QuarterAggregate|YearAggregate|LastAggregate
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

        if ($period === 'last20') {
            return (new LastAggregate())
                ->setLimit(20)
                ->setType($type);
        }

        throw new InvalidArgumentException('Invalid aggregate period.');
    }
}
