<?php

declare(strict_types=1);

namespace App\Services\Cache;

use App\Contracts\Cache as Contract;
use Illuminate\Cache\TaggedCache;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

final class PriceChartCache implements Contract
{
    use Concerns\ManagesCache;
    use Concerns\ManagesChart;

    public function getDay(): Collection
    {
        return $this->get('day');
    }

    public function setDay(string $currency, Collection $data): Collection
    {
        return $this->put("day.$currency", $this->chartjs($data));
    }

    public function getWeek(): Collection
    {
        return $this->get('week');
    }

    public function setWeek(string $currency, Collection $data): Collection
    {
        return $this->put("week.$currency", $this->chartjs($data));
    }

    public function getMonth(): Collection
    {
        return $this->get('month');
    }

    public function setMonth(string $currency, Collection $data): Collection
    {
        return $this->put("month.$currency", $this->chartjs($data));
    }

    public function getQuarter(): Collection
    {
        return $this->get('quarter');
    }

    public function setQuarter(string $currency, Collection $data): Collection
    {
        return $this->put("quarter.$currency", $this->chartjs($data));
    }

    public function getYear(): Collection
    {
        return $this->get('year');
    }

    public function setYear(string $currency, Collection $data): Collection
    {
        return $this->put("year.$currency", $this->chartjs($data));
    }

    public function getCache(): TaggedCache
    {
        return Cache::tags('price_chart');
    }
}
