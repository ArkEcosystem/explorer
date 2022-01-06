<?php

declare(strict_types=1);

namespace App\Enums;

enum CoreTransactionTypeEnum: int
{
    case TRANSFER = 0;

    case SECOND_SIGNATURE = 1;

    case DELEGATE_REGISTRATION = 2;

    case VOTE = 3;

    case MULTI_SIGNATURE = 4;

    case IPFS = 5;

    case MULTI_PAYMENT = 6;

    case DELEGATE_RESIGNATION = 7;

    case TIMELOCK = 8;

    case TIMELOCK_CLAIM = 9;

    case TIMELOCK_REFUND = 10;
}
