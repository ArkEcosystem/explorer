<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Http\Livewire\Concerns\BlocksOrdering;
use App\Models\Block;
use App\ViewModels\ViewModelFactory;
use ARKEcosystem\UserInterface\Http\Livewire\Concerns\HasPagination;
use Illuminate\View\View;
use Livewire\Component;

final class WalletBlockTable extends Component
{
    use HasPagination;
    use BlocksOrdering;

    public string $publicKey;

    public string $username;

    /** @phpstan-ignore-next-line */
    protected $listeners = [
        'orderBlocksBy',
    ];

    public function mount(string $publicKey, string $username): void
    {
        $this->publicKey = $publicKey;
        $this->username  = $username;
    }

    public function render(): View
    {
        $query = Block::where('generator_public_key', $this->publicKey)->scoped($this->getOrderingScope(), $this->blocksOrderingDirection);

        return view('livewire.block-table', [
            'blocks' => ViewModelFactory::paginate($query->paginate()),
        ]);
    }
}
