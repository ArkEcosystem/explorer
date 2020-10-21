<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Models\Block;
use App\ViewModels\ViewModelFactory;
use ARKEcosystem\UserInterface\Http\Livewire\Concerns\HasPagination;
use Illuminate\View\View;
use Livewire\Component;

final class BlockTable extends Component
{
    use HasPagination;

    public bool $viewMore = false;

    public function mount(bool $viewMore = false): void
    {
        $this->viewMore = $viewMore;
    }

    public function render(): View
    {
        return view('livewire.block-table', [
            'blocks' => ViewModelFactory::paginate(Block::latestByHeight()->paginate()),
        ]);
    }
}
