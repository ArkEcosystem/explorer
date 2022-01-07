<?php

declare(strict_types=1);

namespace App\Services;

use Brick\Math\BigDecimal;
use Stringable;

final class BigNumber implements Stringable
{
    private BigDecimal $value;

    /**
     * @param int|float|string $value
     */
    private function __construct($value)
    {
        $this->value = BigDecimal::of($value);
    }

    /**
     * @codeCoverageIgnore
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->value;
    }

    public static function new(float|int|string $value): self
    {
        return new static($value);
    }

    public function plus(BigDecimal|int|string $value): self
    {
        $this->value = $this->value->plus($value);

        return $this;
    }

    public function toNumber(): int
    {
        return $this->value->toInt();
    }

    public function toInt(): int
    {
        return intval($this->toFloat());
    }

    public function toFloat(): float
    {
        return $this->value->exactlyDividedBy(1e8)->toFloat();
    }

    public function valueOf(): BigDecimal
    {
        return $this->value;
    }
}
