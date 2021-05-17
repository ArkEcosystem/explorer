<?php

declare(strict_types=1);

namespace App\Services;

use Konceiver\BetterNumberFormatter\BetterNumberFormatter;

final class NumberFormatter
{
    /**
     * @param string|int|float $value
     */
    public static function number($value): string
    {
        return BetterNumberFormatter::new()->formatWithDecimal((float) $value);
    }

    /**
     * @param string|int|float $value
     */
    public static function percentage($value): string
    {
        return BetterNumberFormatter::new()->formatWithPercent((float) $value, 2);
    }

    /**
     * @param string|int|float $value
     */
    public static function satoshi($value): string
    {
        return BetterNumberFormatter::new()->formatWithDecimal(BigNumber::new($value)->toFloat());
    }

    /**
     * @param string|int|float $value
     */
    public static function currency($value, string $currency, ?int $decimals = null): string
    {
        return BetterNumberFormatter::new()->formatWithCurrencyCustom($value, $currency, $decimals);
    }

    /**
     * @param string|int|float $value
     */
    public static function currencyShort($value, string $currency): string
    {
        return BetterNumberFormatter::new()->formatWithCurrencyShort($value, $currency);
    }

    // TODO: Replace with the proper method once implemented in bribri's package
    public static function format_number_in_k_notation(int $number): string
    {
        $suffixByNumber = function () use ($number) {
            if ($number < 1000) {
                return sprintf('%d', $number);
            }

            if ($number < 1000000) {
                return sprintf('%d%s', floor($number / 1000), 'K');
            }

            return sprintf('%0.2f%s', round($number / 1000000, 2), 'M');
        };

        return $suffixByNumber();
    }
}
