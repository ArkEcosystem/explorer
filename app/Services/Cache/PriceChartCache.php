<?php

declare(strict_types=1);

namespace App\Services\Cache;

use App\Contracts\Cache as Contract;
use Carbon\Carbon;
use Illuminate\Cache\TaggedCache;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

final class PriceChartCache implements Contract
{
    use Concerns\ManagesCache;
    use Concerns\ManagesChart;

    public function getDay(Collection $prices): Collection
    {
        return $this->get('day');
    }

    public function setDay(Collection $prices): Collection
    {
        return $this->remember('day', fn () => $this->groupByDate($prices->take(1), 'H:s'));
    }

    public function getWeek(Collection $prices): Collection
    {
        return $this->get('week');
    }

    public function setWeek(Collection $prices): Collection
    {
        return $this->remember('week', fn () => $this->groupByDate($prices->take(7), 'd.m'));
    }

    public function getMonth(Collection $prices): Collection
    {
        return $this->get('month');
    }

    public function setMonth(Collection $prices): Collection
    {
        return $this->remember('month', fn () => $this->groupByDate($prices->take(30), 'd.m'));
    }

    public function getQuarter(Collection $prices): Collection
    {
        return $this->get('quarter');
    }

    public function setQuarter(Collection $prices): Collection
    {
        return $this->remember('quarter', fn () => $this->groupByDate($prices->take(120), 'W'));
    }

    public function getYear(Collection $prices): Collection
    {
        return $this->get('year');
    }

    public function setYear(Collection $prices): Collection
    {
        return $this->remember('year', fn () => $this->groupByDate($prices->take(365), 'M'));
    }

    public function getCache(): TaggedCache
    {
        return Cache::tags('price_chart');
    }

    private function groupByDate(Collection $datasets, string $dateFormat): Collection
    {
        return $datasets
            ->groupBy(fn ($_, $key) => Carbon::parse($key)->format($dateFormat))
            ->mapWithKeys(fn ($values, $key) => [$key => $values->first()])
            ->ksort();
    }
}
