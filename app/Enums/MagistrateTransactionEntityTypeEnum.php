<?php

declare(strict_types=1);

namespace App\Enums;

enum MagistrateTransactionEntityTypeEnum: int
{
    case BUSINESS = 0;

    case PRODUCT = 1;

    case PLUGIN = 2;

    case MODULE = 3;

    case DELEGATE = 4;
}
