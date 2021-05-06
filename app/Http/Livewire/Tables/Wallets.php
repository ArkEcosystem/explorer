<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tables;

use App\Http\Livewire\Concerns\WalletsOrdering;
use App\ViewModels\ViewModelFactory;
use ARKEcosystem\UserInterface\Http\Livewire\Concerns\HasPagination;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Component;

final class Wallets extends Component
{
    use WalletsOrdering;
    use HasPagination;

    public bool $viewMore = false;

    protected LengthAwarePaginator $wallets;

    public function mount(Builder $wallets): void
    {
        $this->wallets = $wallets->paginate();
    }

    public function render(): View
    {
        return view('livewire.tables.wallets', [
            'wallets' => ViewModelFactory::paginate($this->wallets),
        ]);
    }
}
