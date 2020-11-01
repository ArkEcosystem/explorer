<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\DTO\Slot;
use App\Facades\Rounds;
use App\Jobs\CacheLastBlockByPublicKey;
use App\Services\Cache\MonitorCache;
use App\Services\Monitor\DelegateTracker;
use App\Services\Monitor\Monitor;
use App\ViewModels\ViewModelFactory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Livewire\Component;

final class MonitorNetwork extends Component
{
    public function render(): View
    {
        // $tracking = DelegateTracker::execute(Monitor::roundDelegates(112168));

        $roundNumber = Rounds::currentRound()->round;
        $heightRange = Monitor::heightRangeByRound($roundNumber);
        $tracking    = DelegateTracker::execute(Rounds::allByRound($roundNumber));

        $delegates = [];

        for ($i = 0; $i < count($tracking); $i++) {
            $delegate = array_values($tracking)[$i];

            // if (Cache::missing('lastBlock:'.$delegate['publicKey'])) {
            //     CacheLastBlockByPublicKey::dispatchSync($delegate['publicKey']);
            // }

            $delegates[] = new Slot([
                'publicKey'  => $delegate['publicKey'],
                'order'      => $i + 1,
                'wallet'     => ViewModelFactory::make(Cache::tags(['delegates'])->get($delegate['publicKey'])),
                'forging_at' => Carbon::now()->addMilliseconds($delegate['time']),
                'last_block' => Cache::get('lastBlock:'.$delegate['publicKey']),
                'status'     => $delegate['status'],
            ], $heightRange);
        }

        return view('livewire.monitor-network', [
            'delegates'  => $delegates,
            'statistics' => [
                'blockCount'      => (new MonitorCache())->getBlockCount($delegates),
                'transactions'    => (new MonitorCache())->getTransactions(),
                'currentDelegate' => (new MonitorCache())->getCurrentDelegate($delegates),
                'nextDelegate'    => (new MonitorCache())->getNextDelegate($delegates),
            ],
        ]);
    }
}
