<?php

declare(strict_types=1);

namespace App\Aggregates;

use App\Contracts\Aggregate;
use App\Models\Wallet;
use App\Services\BigNumber;
use App\Services\Blockchain\NetworkStatus;
use App\Services\NumberFormatter;
use Mattiasgeniar\Percentage\Percentage;

final class VotePercentageAggregate implements Aggregate
{
    public function aggregate(): string
    {
        return Percentage::calculate(
            BigNumber::new(Wallet::sum('balance'))->toFloat(),
            NetworkStatus::supply()
        );
    }
}
