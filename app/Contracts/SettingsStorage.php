<?php

declare(strict_types=1);

namespace App\Contracts;

interface SettingsStorage
{
    public static function all(): array;

    public static function currency(): string;

    public static function locale(): string;

    public static function priceChart(): bool;

    public static function feeChart(): bool;

    public static function darkTheme(): bool;

    public static function theme(): string;

    public static function compactTables(): bool;

    public static function usesCharts(): bool;

    public static function usesPriceChart(): bool;

    public static function usesFeeChart(): bool;

    public static function usesDarkTheme(): bool;

    public static function usesCompactTables(): bool;
}
