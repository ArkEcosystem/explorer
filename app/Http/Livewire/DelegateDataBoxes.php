<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use Illuminate\View\View;
use Livewire\Component;

final class DelegateDataBoxes extends Component
{
    public function render(): View
    {
        return view('livewire.delegate-data-boxes');
    }
}
