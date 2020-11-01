<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Facades\Network;
use App\Services\Cache\AggregateCache;
use Illuminate\View\View;
use Livewire\Component;

final class MonitorStatistics extends Component
{
    public function render(): View
    {
        return view('livewire.monitor-statistics', [
            'delegateRegistrations' => (new AggregateCache())->getDelegateRegistrationCount(),
            'blockReward'           => Network::blockReward(),
            'feesCollected'         => (new AggregateCache())->getFeesCollected(),
            'votes'                 => (new AggregateCache())->getVotes(),
            'votesPercentage'       => (new AggregateCache())->getVotesPercentage(),
        ]);
    }
}
