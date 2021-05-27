<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Actions\CacheNetworkSupply;
use App\Facades\Network;
use App\Models\Wallet;
use App\Services\Cache\NetworkCache;
use App\Services\NumberFormatter;
use Illuminate\View\View;
use Livewire\Component;

final class StatsHighlights extends Component
{
    private ?string $currency;

    public function mount(): void
    {
        $this->currency = Network::currency();
    }

    public function render(): View
    {
        return view('livewire.stats-highlights', [
            'votingPercent' => $this->getVotingPercent(),
            'votingValue'   => $this->getVotingValue(),
            'totalSupply'   => $this->getTotalSupply(),
            'delegates'     => $this->getDelegates(),
            'wallets'       => $this->getWallets(),
        ]);
    }

    private function getTotalSupply(): string
    {
        $supply = CacheNetworkSupply::execute() / 1e8;

        return NumberFormatter::currency($supply, $this->currency);
    }

    private function getVotingPercent(): string
    {
        $votesPercent = (new NetworkCache())->getVotesPercentage();

        return NumberFormatter::percentage($votesPercent);
    }

    private function getVotingValue(): string
    {
        $votesValue = (new NetworkCache())->getVotesCount();

        return NumberFormatter::currency($votesValue, $this->currency);
    }

    private function getDelegates(): string
    {
        $registeredDelegates = (new NetworkCache())->getDelegateRegistrationCount();

        return NumberFormatter::number($registeredDelegates);
    }

    private function getWallets(): string
    {
        $wallets = Wallet::count();

        return NumberFormatter::number($wallets);
    }
}
