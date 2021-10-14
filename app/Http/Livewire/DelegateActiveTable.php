<?php

namespace App\Http\Livewire;

use App\Facades\Network;
use App\Models\Wallet;
use App\ViewModels\ViewModelFactory;
use Illuminate\Support\Collection;
use Livewire\Component;

class DelegateActiveTable extends Component
{
    public function render()
    {
        return view('livewire.delegate-active-table', [
            'delegates' => $this->delegates(),
        ]);
    }

    private function delegates(): Collection
    {
        return ViewModelFactory::collection(
            Wallet::query()
                ->whereNotNull('attributes->delegate->username')
                ->whereRaw("(\"attributes\"->'delegate'->>'rank')::numeric <= ?", [Network::delegateCount()])
                ->orderByRaw("(\"attributes\"->'delegate'->>'rank')::numeric ASC")
                ->get()
        );
    }
}
