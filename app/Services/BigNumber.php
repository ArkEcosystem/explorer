<?php

declare(strict_types=1);

namespace App\Services;

use Brick\Math\BigDecimal;

final class BigNumber
{
    private BigDecimal $value;

    /**
     * @param int|string $value
     */
    private function __construct($value)
    {
        $this->value = BigDecimal::of($value);
    }

    /**
     * @param int|string $value
     */
    public static function new($value)
    {
        return new static($value);
    }

    public function plus($value): self
    {
        $this->value = $this->value->plus($value);

        return $this;
    }

    public function minus($value): self
    {
        $this->value = $this->value->minus($value);

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
