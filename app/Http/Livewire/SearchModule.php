<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Services\Search\BlockSearch;
use App\Services\Search\TransactionSearch;
use Illuminate\Validation\Rule;
use Livewire\Component;

final class SearchModule extends Component
{
    public array $state = [
        // Generic
        'term'        => null,
        'type'        => null,
        'dateFrom'    => null,
        'dateTo'      => null,
        // Blocks
        'totalAmountFrom'    => null,
        'totalAmountTo'      => null,
        'totalFeeFrom'       => null,
        'totalFeeTo'         => null,
        'generatorPublicKey' => null,
        // Transactions
        'transactionType' => null,
        'amountFrom'      => null,
        'amountTo'        => null,
        'feeFrom'         => null,
        'feeTo'           => null,
        'smartBridge'     => null,
        // Wallets
        'username'    => null,
        'vote'        => null,
        'balanceFrom' => null,
        'balanceTo'   => null,
    ];

    public bool $isSlim = false;

    public bool $isAdvanced = false;

    public function mount(bool $isSlim = false, bool $isAdvanced = false): void
    {
        $this->isSlim     = $isSlim;
        $this->isAdvanced = $isAdvanced;
    }

    public function performSearch(): void
    {
        $data = $this->validate([
            // Generic
            'state'             => 'array',
            'state.term'        => ['nullable', 'string', 'max:255'],
            'state.type'        => ['nullable', Rule::in(['blocks', 'transactions', 'wallets'])],
            'state.dateFrom'    => ['nullable', 'date'],
            'state.dateTo'      => ['nullable', 'date'],
            // Blocks
            'state.totalAmountFrom'    => ['nullable', 'integer', 'min:0', 'max:100'],
            'state.totalAmountTo'      => ['nullable', 'integer', 'min:0', 'max:100'],
            'state.totalFeeFrom'       => ['nullable', 'integer', 'min:0', 'max:100'],
            'state.totalFeeTo'         => ['nullable', 'integer', 'min:0', 'max:100'],
            'state.generatorPublicKey' => ['nullable', 'string', 'max:255'],
            // Transactions
            'state.transactionType' => ['nullable', 'string'], // @TODO: validate based on an enum
            'state.amountFrom'      => ['nullable', 'integer', 'min:0', 'max:100'],
            'state.amountTo'        => ['nullable', 'integer', 'min:0', 'max:100'],
            'state.feeFrom'         => ['nullable', 'integer', 'min:0', 'max:100'],
            'state.feeTo'           => ['nullable', 'integer', 'min:0', 'max:100'],
            'state.smartBridge'     => ['nullable', 'string', 'max:255'],
            // Wallets
            'state.username'    => ['nullable', 'string', 'max:255'],
            'state.vote'        => ['nullable', 'string', 'max:255'],
            'state.balanceFrom' => ['nullable', 'integer', 'min:0', 'max:100'],
            'state.balanceTo'   => ['nullable', 'integer', 'min:0', 'max:100'],
        ])['state'];

        if ($this->state['type'] === 'blocks') {
            $this->results = (new BlockSearch())->search($data)->paginate();
        }

        if ($this->state['type'] === 'transactions') {
            $this->results = (new TransactionSearch())->search($data)->paginate();
        }

        if ($this->state['type'] === 'wallets') {
            $this->results = (new WalletSearch())->search($data)->paginate();
        }

        // $this->emitTo('', $data);
    }
}
