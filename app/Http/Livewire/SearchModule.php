<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Http\Livewire\Concerns\ManagesSearch;
use App\Services\Search\BlockSearch;
use App\Services\Search\TransactionSearch;
use App\Services\Search\WalletSearch;
use Livewire\Component;

final class SearchModule extends Component
{
    use ManagesSearch;

    public bool $isSlim = false;

    public bool $isAdvanced = false;

    public function mount(bool $isSlim = false, bool $isAdvanced = false): void
    {
        $this->isSlim     = $isSlim;
        $this->isAdvanced = $isAdvanced;

        $this->restoreState(request('state', []));
    }

    public function performSearch(): void
    {
        $data = $this->validateSearchQuery();

        if ($this->isAdvanced) {
            $this->emit('searchTriggered', $data);
        } else {
            if ($this->searchWallet()) {
                return;
            }

            if ($this->searchTransaction()) {
                return;
            }

            if ($this->searchBlock()) {
                return;
            }

            $this->redirectRoute('search', ['state' => $data]);
        }
    }

    private function searchWallet(): bool
    {
        $wallet = (new WalletSearch())->search(['term' => $this->state['term']])->first();

        if ($wallet) {
            $this->redirectRoute('wallet', $wallet->address);

            return true;
        }

        return false;
    }

    private function searchTransaction(): bool
    {
        $transaction = (new TransactionSearch())->search(['term' => $this->state['term']])->first();

        if ($transaction) {
            $this->redirectRoute('transaction', $transaction->id);

            return true;
        }

        return false;
    }

    private function searchBlock(): bool
    {
        $block = (new BlockSearch())->search(['term' => $this->state['term']])->first();

        if ($block) {
            $this->redirectRoute('block', $block->id);

            return true;
        }

        return false;
    }
}
