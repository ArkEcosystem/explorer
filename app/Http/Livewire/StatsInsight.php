<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use Illuminate\View\View;
use Livewire\Component;

final class StatsInsight extends Component
{
    public ?string $selected;

    public function render(): View
    {
        return view('livewire.stats-insights', [
            '' => '',
        ]);
    }
}
