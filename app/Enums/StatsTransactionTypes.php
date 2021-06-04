<?php

declare(strict_types=1);

namespace App\Enums;

final class StatsTransactionTypes
{
    public const ALL = 'all';

    public const TRANSFER = 'transfer';

    public const SECOND_SIG = 'secondSignature';

    public const DELEGATE_REG = 'delegateRegistration';

    public const VOTE = 'vote';

    public const MULTI_SIG = 'multiSignature';

    public const IPFS = 'ipfs';

    public const MULTI_PAY = 'multiPayment';

    public const DELEGATE_RES = 'delegateResignation';

    public const TIMELOCK = 'htlcLock';

    public const TIMELOCK_CLAIM = 'htlcClaim';

    public const TIMELOCK_REFUND = 'htlcRefund';

    public const MAGISTRATE = 'magistrate';
}
