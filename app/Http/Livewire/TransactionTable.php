<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Models\Transaction;
use App\ViewModels\ViewModelFactory;
use ARKEcosystem\UserInterface\Http\Livewire\Concerns\HasPagination;
use Livewire\Component;

final class TransactionTable extends Component
{
    use HasPagination;

    public bool $viewMore = false;

    public function mount(bool $viewMore = false)
    {
        $this->viewMore = $viewMore;
    }

    public function render()
    {
        return view('livewire.transaction-table', [
            'transactions' => ViewModelFactory::paginate(Transaction::latestByTimestamp()->paginate()),
        ]);
    }
}
