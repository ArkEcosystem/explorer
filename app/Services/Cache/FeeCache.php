<?php

declare(strict_types=1);

namespace App\Services\Cache;

use App\Contracts\Cache as Contract;
use App\Services\Cache\Concerns\ManagesCache;
use App\Services\Cache\Concerns\ManagesChart;
use Illuminate\Cache\TaggedCache;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

final class FeeCache implements Contract
{
    use ManagesCache;
    use ManagesChart;

    public function all(string $period, ?string $type = null): array
    {
        return [
            'historical' => $this->getHistorical($period),
            'min'        => $this->getMinimum($period, $type),
            'avg'        => $this->getAverage($period, $type),
            'max'        => $this->getMaximum($period, $type),
        ];
    }

    public function getHistorical(string $period): array
    {
        return $this->get(sprintf('historical/%s', $period), []);
    }

    public function setHistorical(string $period, Collection $data): void
    {
        $this->put(sprintf('historical/%s', $period), $this->chartjs($data));
    }

    public function getMinimum(string $period, ?string $type = null): float
    {
        $key = collect(['minimum', $period, $type])->filter()->join('/');

        return (float) $this->get($key);
    }

    public function setMinimum(string $period, float $data, ?string $type = null): void
    {
        $key = collect(['minimum', $period, $type])->filter()->join('/');

        $this->put($key, $data);
    }

    public function getAverage(string $period, ?string $type = null): float
    {
        $key = collect(['average', $period, $type])->filter()->join('/');

        return (float) $this->get($key);
    }

    public function setAverage(string $period, float $data, ?string $type = null): void
    {
        $key = collect(['average', $period, $type])->filter()->join('/');

        $this->put($key, $data);
    }

    public function getMaximum(string $period, ?string $type = null): float
    {
        $key = collect(['maximum', $period, $type])->filter()->join('/');

        return (float) $this->get($key);
    }

    public function setMaximum(string $period, float $data, ?string $type = null): void
    {
        $key = collect(['maximum', $period, $type])->filter()->join('/');

        $this->put($key, $data);
    }

    public function getCache(): TaggedCache
    {
        return Cache::tags('fee');
    }
}
