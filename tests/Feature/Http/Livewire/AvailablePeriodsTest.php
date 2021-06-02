<?php

declare(strict_types=1);

use App\Http\Livewire\Concerns\AvailablePeriods;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\Livewire;

beforeEach(fn () => Carbon::setTestNow('2020-06-15 00:00:00'));

it('should return the date from period', function ($period, $from, $fromEpoch) {
    Livewire::test(TestComponent::class)
        ->set('period', $period)
        ->assertSee($period)
        ->assertSee($from)
        ->assertSee($fromEpoch);
})->with([
    ['day', '2020-06-14', '1973-03-26'],
    ['week', '2020-06-08', '1973-03-20'],
    ['month', '2020-05-15', '1973-02-27'],
    ['quarter', '2020-03-15', '1972-12-27'],
    ['year', '2019-06-15', '1972-03-27'],
    ['all', '1920-06-15', '1873-03-27'],
]);

final class AvailablePeriodsTest extends Component
{
    use AvailablePeriods;

    public string $period = 'day';

    public ?string $range;

    public ?string $rangeEpoch;

    public function updatedPeriod()
    {
        $this->rangeEpoch = $this->getRangeFromPeriod($this->period);
        $this->range      = $this->getRangeFromPeriodWithoutArkEpoch($this->period);
    }

    public function render()
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
