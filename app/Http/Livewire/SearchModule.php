<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SearchModule extends Component
{
    public ?string $term;

    public ?string $type;

    public ?float $amountRangeFrom;
    public ?float $amountRangeTo;

    public ?float $feeRangeFrom;
    public ?float $feeRangeTo;

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
