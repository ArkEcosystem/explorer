<?php

declare(strict_types=1);

namespace App\View\Components;

use App\Services\NumberFormatter;
use Closure;
use Illuminate\View\Component;

final class Percentage extends Component
{
    public function render(): Closure
    {
        return function (array $data) {
            return NumberFormatter::percentage($data['slot']);
        };
    }
}
