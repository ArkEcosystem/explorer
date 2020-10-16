<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SearchModule extends Component
{
    public ?string $term;

    public ?string $type;

    public ?string $amountRangeFrom;

    public ?string $amountRangeTo;

    public ?string $feeRangeFrom;

    public ?string $feeRangeTo;

    public ?float $dateFrom;

    public ?float $dateTo;

    public function render()
    {
        return view('livewire.search-module');
    }

    public function performSearch()
    {
        return view('livewire.search-module');
    }
}
