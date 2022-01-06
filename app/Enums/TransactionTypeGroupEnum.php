<?php

declare(strict_types=1);

namespace App\Enums;

enum TransactionTypeGroupEnum: int
{
    case CORE = 1;

    case MAGISTRATE = 2;
}
