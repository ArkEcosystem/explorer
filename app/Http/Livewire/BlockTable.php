<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Http\Livewire\Concerns\BlocksOrdering;
use App\Models\Block;
use App\ViewModels\ViewModelFactory;
use ARKEcosystem\UserInterface\Http\Livewire\Concerns\HasPagination;
use Illuminate\View\View;
use Livewire\Component;

final class BlockTable extends Component
{
    use HasPagination;
    use BlocksOrdering;

    /** @phpstan-ignore-next-line */
    protected $listeners = [
        'orderBlocksBy',
    ];

    public function render(): View
    {
        $query = Block::withScope($this->getOrderingScope(), $this->orderingDirection);

        return view('livewire.block-table', [
            'blocks' => ViewModelFactory::paginate($query->paginate()),
        ]);
    }
}
