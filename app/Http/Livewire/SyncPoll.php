<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Facades\Network;
use Illuminate\View\View;
use Livewire\Component;

class SyncPoll extends Component
{
    public int $seconds;

    public function mount(int $seconds = 2): void
    {
        $this->seconds = Network::blockTime() / 2;
    }

    public function render(): View
    {
        return view('livewire.sync-poll');
    }

    public function polling(): void
    {
        $this->emit('polling');
    }
}
