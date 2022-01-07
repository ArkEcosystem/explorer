<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\CryptoCurrencies;
use ARKEcosystem\Foundation\NumberFormatter\NumberFormatter as BetterNumberFormatter;
use ARKEcosystem\Foundation\NumberFormatter\ResolveScientificNotation;

final class NumberFormatter
{
    final public const CRYPTO_DECIMALS = 8;

    final public const FIAT_DECIMALS = 2;

    public static function number(float|int|string $value): string
    {
        return BetterNumberFormatter::new()->formatWithDecimal((float) $value);
    }

    public static function percentage(float|int|string $value): string
    {
        return BetterNumberFormatter::new()->formatWithPercent((float) $value, 2);
    }

    public static function satoshi(float|int|string $value): string
    {
        return BetterNumberFormatter::new()->formatWithDecimal(BigNumber::new($value)->toFloat());
    }

    public static function currency(float|int|string $value, string $currency): string
    {
        if (! static::isFiat($currency)) {
            return BetterNumberFormatter::new()
                ->formatWithCurrencyCustom($value, $currency, static::decimalsFor($currency));
        }

        return BetterNumberFormatter::new()
            ->withLocale('international')
            ->withFractionDigits(static::decimalsFor($currency))
            ->formatCurrency((float) $value, $currency);
    }

    public static function currencyWithoutSuffix(float|int|string $value, string $currency): string
    {
        return trim(BetterNumberFormatter::new()->formatWithCurrencyCustom($value, '', static::decimalsFor($currency)));
    }

    public static function currencyWithDecimalsWithoutSuffix(float|int|string $value, string $currency): string
    {
        return number_format((float) ResolveScientificNotation::execute((float) $value), static::decimalsFor($currency));
    }

    public static function currencyShort(float|int|string $value, string $currency): string
    {
        return BetterNumberFormatter::new()->formatWithCurrencyShort($value, $currency);
    }

    public static function currencyShortNotation(float|int|string $value): string
    {
        $value = is_string($value) ? (float) $value : $value;

        if ($value < 1000) {
            return sprintf('%d', $value);
        }

        if ($value < 1000000) {
            return sprintf('%d%s', number_format($value / 1000, 3), 'K');
        }

        return sprintf('%0.2f%s', number_format($value / 1000000, 6), 'M');
    }

    public static function isFiat(string $currency): bool
    {
        return ! collect(CryptoCurrencies::cases())
            ->map(fn (CryptoCurrencies $currency) => $currency->name)
            ->containsStrict($currency);
    }

    public static function decimalsFor(string $currency): int
    {
        if (static::isFiat($currency)) {
            return self::FIAT_DECIMALS;
        }

        return self::CRYPTO_DECIMALS;
    }
}
