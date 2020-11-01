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

    public function setDay(): Collection
    {
        return $this->put('fees_per_day', (new FeesByDayAggregate())->aggregate());
    }

    public function getDay(): Collection
    {
        return $this->get('fees_per_day');
    }

    public function setWeek(): Collection
    {
        return $this->put('fees_per_week', (new FeesByWeekAggregate())->aggregate());
    }

    public function getWeek(): Collection
    {
        return $this->get('fees_per_week');
    }

    public function setMonth(): Collection
    {
        return $this->put('fees_per_month', (new FeesByMonthAggregate())->aggregate());
    }

    public function getMonth(): Collection
    {
        return $this->get('fees_per_month');
    }

    public function setQuarter(): Collection
    {
        return $this->put('fees_per_quarter', (new FeesByQuarterAggregate())->aggregate());
    }

    public function getQuarter(): Collection
    {
        return $this->get('fees_per_quarter');
    }

    public function setYear(): Collection
    {
        return $this->put('fees_per_year', (new FeesByYearAggregate())->aggregate());
    }

    public function getYear(): Collection
    {
        return $this->get('fees_per_year');
    }

    public function getCache(): TaggedCache
    {
        return Cache::tags('fee_chart');
    }
}
