<?php

declare(strict_types=1);

namespace App\Enums;

final class StatsTransactionTypes
{
    public const TRANSFER = 'transfer';

    public const SECOND_SIG = 'secondSignature';

    public const DELEGATE_REG = 'delegateRegistration';

    public const VOTE = 'vote';

    public const MULTI_SIG = 'multiSignature';

    public const IPFS = 'ipfs';

    public const MULTI_PAY = 'multiPayment';

    public const DELEGATE_RES = 'delegateResignation';

    public const TIMELOCK = 'timelock';

    public const TIMELOCK_CLAIM = 'timelockClaim';

    public const TIMELOCK_REFUND = 'timelockRefund';

    public const MAGISTRATE = 'magistrate';
}
