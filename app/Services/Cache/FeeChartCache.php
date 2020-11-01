<?php

declare(strict_types=1);

namespace App\Services\Cache;

use App\Contracts\Cache as Contract;
use Illuminate\Cache\TaggedCache;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

final class FeeChartCache implements Contract
{
    use Concerns\ManagesCache;
    use Concerns\ManagesChart;

    public function setDay(Collection $value): void
    {
        $this->put('fees_per_day', $value);
    }

    public function getDay(): Collection
    {
        return $this->get('fees_per_day');
    }

    public function setWeek(Collection $value): void
    {
        $this->put('fees_per_week', $value);
    }

    public function getWeek(): Collection
    {
        return $this->get('fees_per_week');
    }

    public function setMonth(Collection $value): void
    {
        $this->put('fees_per_month', $value);
    }

    public function getMonth(): Collection
    {
        return $this->get('fees_per_month');
    }

    public function setQuarter(Collection $value): void
    {
        $this->put('fees_per_quarter', $value);
    }

    public function getQuarter(): Collection
    {
        return $this->get('fees_per_quarter');
    }

    public function setYear(Collection $value): void
    {
        $this->put('fees_per_year', $value);
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
