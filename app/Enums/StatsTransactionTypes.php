<?php

declare(strict_types=1);

namespace App\Enums;

final class StatsTransactionTypes
{
    public const ALL = 'all';
    public const TRANSFER = '1:transfer';
    public const SECOND_SIG = '1:secondSignature';
    public const DELEGATE_REG = '1:delegateRegistration';
    public const VOTE = '1:vote';
    public const MULTI_SIG = '1:multiSignature';
    public const IPFS = '1:ipfs';
    public const MULTI_PAY = '1:multiPayment';
    public const DELEGATE_RES = '1:delegateResignation';
    public const TIMELOCK = '1:htlcLock';
    public const TIMELOCK_CLAIM = '1:htlcClaim';
    public const TIMELOCK_REFUND = '1:htlcRefund';
    public const MAGISTRATE = 'magistrate';
}
