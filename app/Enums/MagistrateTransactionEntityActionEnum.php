<?php

declare(strict_types=1);

namespace App\Enums;

enum MagistrateTransactionEntityActionEnum: int
{
    case REGISTER = 0;

    case UPDATE = 1;

    case RESIGN = 2;
}
