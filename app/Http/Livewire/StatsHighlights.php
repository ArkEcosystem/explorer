<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use Illuminate\View\View;
use Livewire\Component;

final class StatsHighlights extends Component
{
    public function render(): View
    {
        $voting = $this->getVoting();

        return view('livewire.stats-highlights', [
            'totalSupply' => $this->getTotalSupply(),
            'votingPercent' => data_get($voting, 'percent'),
            'votingValue' => data_get($voting, 'value'),
            'delegates' => $this->getDelegates(),
            'wallets' => $this->getWallets(),
        ]);
    }

    private function getTotalSupply(): string
    {
        // @TODO
        return number_format(155558312).' ARK';
    }

    private function getVoting(): array
    {
        // @TODO
        return [
            'percent' => number_format(74.08, 2).'%',
            'value' => number_format(84235364.45, 2).' ARK',
        ];
    }

    private function getDelegates(): string
    {
        // @TODO
        return number_format(1171);
    }

    private function getWallets(): string
    {
        // @TODO
        return number_format(150235);
    }
}
