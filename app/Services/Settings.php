<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;

final class Settings
{
    public static function all(): array
    {
        // TODO: needs a migration to work with `compactTable`
        if (Session::has('settings')) {
            return json_decode(Session::get('settings'), true);
        }

        return [
            'currency'   => 'USD',
            'priceChart' => true,
            'feeChart'   => true,
            'darkTheme'  => false,
            'compactTable' => false,
        ];
    }

    public static function currency(): string
    {
        return Arr::get(static::all(), 'currency', 'USD');
    }

    public static function priceChart(): bool
    {
        return Arr::get(static::all(), 'priceChart', true);
    }

    public static function feeChart(): bool
    {
        return Arr::get(static::all(), 'feeChart', true);
    }

    public static function darkTheme(): bool
    {
        return Arr::get(static::all(), 'darkTheme', true);
    }

    public static function theme(): string
    {
        if (static::darkTheme()) {
            return 'dark';
        }

        return 'light';
    }

    public static function compactTable(): bool
     {
         return Arr::get(static::all(), 'compactTable', true);
     }

    public static function usesCharts(): bool
    {
        return static::usesPriceChart() || static::usesFeeChart();
    }

    public static function usesPriceChart(): bool
    {
        if (config('explorer.network') !== 'production') {
            return false;
        }

        return static::priceChart() === true;
    }

    public static function usesFeeChart(): bool
    {
        return static::feeChart() === true;
    }

    public static function usesDarkTheme(): bool
    {
        return static::darkTheme() === true;
    }

    public static function usesCompactTable(): bool
    {
        return static::compactTable() === true;
    }
}
