<?php

declare(strict_types=1);

namespace App\Services\Transactions\Aggregates\Historical;

use App\Facades\Network;
use App\Services\Transactions\Aggregates\Concerns\HasQueries;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class RangeAggregate
{
    use HasQueries;

    public function aggregate(Carbon $start, Carbon $end, string $format): Collection
    {
        $select = [
            'MAX(timestamp) as timestamp',
            'COUNT(*) as total',
            sprintf("to_char(to_timestamp(%d+timestamp) AT TIME ZONE 'UTC', '%s') as formated_date", Network::epoch()->timestamp, $format),
        ];

        return $this
            ->dateRangeQuery($start, $end)
            ->select(DB::raw(implode(', ', $select)))
            ->orderBy('formated_date')
            ->groupBy('formated_date')
            ->pluck('total', 'formated_date');
    }
}
