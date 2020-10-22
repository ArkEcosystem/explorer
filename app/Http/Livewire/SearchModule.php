<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Http\Livewire\Concerns\ManagesSearch;
use App\Models\Block;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Services\Search\BlockSearch;
use App\Services\Search\TransactionSearch;
use App\Services\Search\WalletSearch;
use Illuminate\View\View;
use Livewire\Component;

final class SearchModule extends Component
{
    use ManagesSearch;

    public bool $isSlim = false;

    protected $queryString = ['state'];

    public function mount(bool $isSlim = false): void
    {
        $this->isSlim = $isSlim;
    }

    public function render(): View
    {
        return view('components.search', ['isAdvanced' => false]);
    }

    public function performSearch(): void
    {
        $data = $this->validateSearchQuery();

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

    private function searchWallet(): bool
    {
        /** @var Wallet|null */
        $wallet = (new WalletSearch())->search(['term' => $this->state['term']])->first();

        if (is_null($wallet)) {
            return false;
        }

        $this->redirectRoute('wallet', $wallet->address);

        return true;
    }

    private function searchTransaction(): bool
    {
        /** @var Transaction|null */
        $transaction = (new TransactionSearch())->search(['term' => $this->state['term']])->first();

        if (is_null($transaction)) {
            return false;
        }

        $this->redirectRoute('transaction', $transaction->id);

        return true;
    }

    private function searchBlock(): bool
    {
        /** @var Block|null */
        $block = (new BlockSearch())->search(['term' => $this->state['term']])->first();

        if (is_null($block)) {
            return false;
        }

        $this->redirectRoute('block', $block->id);

        return true;
    }
}
