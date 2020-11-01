<?php

declare(strict_types=1);

namespace App\Services\Cache;

use App\Contracts\Cache as Contract;
use App\Services\Transactions\Aggregates\FeesByDayAggregate;
use App\Services\Transactions\Aggregates\FeesByMonthAggregate;
use App\Services\Transactions\Aggregates\FeesByQuarterAggregate;
use App\Services\Transactions\Aggregates\FeesByWeekAggregate;
use App\Services\Transactions\Aggregates\FeesByYearAggregate;
use Illuminate\Cache\TaggedCache;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

final class FeeChartCache implements Contract
{
    use Concerns\ManagesCache;
    use Concerns\ManagesChart;

    public function getDay(): Collection
    {
        return $this->remember('fees_per_day', fn () => (new FeesByDayAggregate())->aggregate());
    }

    public function getWeek(): Collection
    {
        return $this->remember('fees_per_week', fn () => (new FeesByWeekAggregate())->aggregate());
    }

    public function getMonth(): Collection
    {
        return $this->remember('fees_per_month', fn () => (new FeesByMonthAggregate())->aggregate());
    }

    public function getQuarter(): Collection
    {
        return $this->remember('fees_per_quarter', fn () => (new FeesByQuarterAggregate())->aggregate());
    }

    public function getYear(): Collection
    {
        return $this->remember('fees_per_year', fn () => (new FeesByYearAggregate())->aggregate());
    }

    public function getCache(): TaggedCache
    {
        return Cache::tags('fee_chart');
    }
}
