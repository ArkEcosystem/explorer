<?php

declare(strict_types=1);

namespace App\Contracts;

use Illuminate\Support\Collection;

interface CryptoDataFetcher
{
    /**
     * @return @var Collection (string date => int price)[]
     */
    public function historical(string $source, string $target, string $format = 'Y-m-d'): Collection;

    public function historicalHourly(string $source, string $target, int $limit = 23, string $format = 'Y-m-d H:i:s'): Collection;

    public function getCurrenciesData(string $source, Collection $targets): Collection;
}
