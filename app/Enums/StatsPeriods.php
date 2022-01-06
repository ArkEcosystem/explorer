<?php

declare(strict_types=1);

namespace App\Enums;

enum StatsPeriods: string
{
    case DAY = 'day';

    case WEEK = 'week';

    case MONTH = 'month';

    case QUARTER = 'quarter';

    case YEAR = 'year';

    case ALL = 'all';
}
