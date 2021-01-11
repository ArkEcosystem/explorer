<?php

declare(strict_types=1);

namespace App\Enums;

final class OrderingTypeEnum
{
    const ADDRESS              = 'address';
    const AMOUNT               = 'amount';
    const BALANCE              = 'balance';
    const BLOCK_AMOUNT         = 'amount';
    const BLOCK_FEE            = 'fee';
    const CONFIRMATIONS        = 'confirmations';
    const FEE                  = 'fee';
    const GENERATOR_PUBLIC_KEY = 'generated_by';
    const HEIGHT               = 'height';
    const ID                   = 'id';
    const RANK                 = 'rank';
    const RECIPIENT            = 'recipient';
    const SENDER               = 'sender';
    const SUPPLY               = 'supply';
    const TIMESTAMP            = 'timestamp';
    const TRANSACTIONS_AMOUNT  = 'transactions';
    const VOTE                 = 'votes';
}
