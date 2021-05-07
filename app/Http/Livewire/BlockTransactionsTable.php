<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Http\Livewire\Concerns\TransactionsOrdering;
use App\Models\Block;
use App\ViewModels\ViewModelFactory;
use ARKEcosystem\UserInterface\Http\Livewire\Concerns\HasPagination;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class BlockTransactionsTable extends Component
{
    use HasPagination;
    use TransactionsOrdering;

    public string $blockId;

    /** @phpstan-ignore-next-line */
    protected $listeners = [
        'orderTransactionsBy',
    ];

    public function mount(string $blockId): void
    {
        $this->blockId = $blockId;
    }

    public function getBlock(): Block
    {
        return Block::findOrFail($this->blockId);
    }

    public function render(): View
    {
        $query = $this->getBlock()->transactions()->withScope($this->getOrderingScope(), $this->orderingDirection);

        return view('livewire.transaction-table', [
            'transactions' => ViewModelFactory::paginate($query->paginate(25)),
        ]);
    }
}
