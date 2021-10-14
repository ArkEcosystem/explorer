<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Facades\Network;
use App\Models\Wallet;
use App\ViewModels\ViewModelFactory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;

class DelegateResignedTable extends Component
{
    use WithPagination;

    /** @phpstan-ignore-next-line */
    protected $listeners = ['tabFiltered'];

    public function render()
    {
        return view('livewire.delegate-resigned-table', [
            'delegates' => $this->delegates(),
        ]);
    }

    public function tabFiltered()
    {
        $this->gotoPage(1);
    }

    private function delegates(): LengthAwarePaginator
    {
        return ViewModelFactory::paginate(
            Wallet::query()
                ->whereNotNull('attributes->delegate->username')
                ->where('attributes->delegate->resigned', true)
                ->paginate(Network::delegateCount())
        );
    }
}
