<?php

declare(strict_types=1);

namespace App\Enums;

enum DelegateForgingStatus
{
    case forging;

    case missed;

    case missing;
}
