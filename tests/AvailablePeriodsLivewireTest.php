<?php

declare(strict_types=1);

namespace Tests;

use App\Http\Livewire\Concerns\AvailablePeriods;
use Livewire\Component;

/**
 * @coversNothing
 */
final class AvailablePeriodsLivewireTest extends Component
{
    use AvailablePeriods;

    public string $period = 'day';

    public ?string $range;

    public ?string $rangeEpoch;

    public function updatedPeriod(): void
    {
        $this->rangeEpoch = $this->getRangeFromPeriod($this->period);
        $this->range      = $this->getRangeFromPeriodWithoutArkEpoch($this->period);
    }

    public function render(): string
    {
        return <<<'blade'
            <div>
                <p>{{ $period }}</p>
                <p>{{ $range }}</p>
                <p>{{ $rangeEpoch }}</p>
            </div>
        blade;
    }
}
