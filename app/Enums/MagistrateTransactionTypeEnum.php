<?php

declare(strict_types=1);

namespace App\Enums;

enum MagistrateTransactionTypeEnum: int
{
    case BUSINESS_REGISTRATION = 0;

    case BUSINESS_RESIGNATION = 1;

    case BUSINESS_UPDATE = 2;

    case BRIDGECHAIN_REGISTRATION = 3;

    case BRIDGECHAIN_RESIGNATION = 4;

    case BRIDGECHAIN_UPDATE = 5;

    case ENTITY = 6;
}
