<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Models\Block;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Services\Timestamp;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
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

    public function mount(bool $isSlim = false): void
    {
        $this->isSlim = $isSlim;
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
            $this->searchBlocks($data);
        }

        if ($this->state['type'] === 'transactions') {
            $this->searchTransactions($data);
        }

        if ($this->state['type'] === 'wallets') {
            $this->searchWallets($data);
        }
    }

    private function searchBlocks(array $parameters): LengthAwarePaginator
    {
        $query = Block::query();

        $this->queryValueRange($query, $parameters['totalAmountFrom'], $parameters['totalAmountTo']);

        $this->queryValueRange($query, $parameters['totalFeeFrom'], $parameters['totalFeeTo']);

        $this->queryDateRange($query, $parameters['dateFrom'], $parameters['dateTo']);

        if ($parameters['generatorPublicKey']) {
            $query->where('generator_public_key', $parameters['generatorPublicKey']);
        }

        return $query->paginate();
    }

    private function searchTransactions(array $parameters): LengthAwarePaginator
    {
        $query = Transaction::query();

        $this->queryValueRange($query, $parameters['amountFrom'], $parameters['amountTo']);

        $this->queryValueRange($query, $parameters['feeFrom'], $parameters['feeTo']);

        $this->queryDateRange($query, $parameters['dateFrom'], $parameters['dateTo']);

        if ($parameters['smartBridge']) {
            $query->where('vendor_field_hex', $parameters['smartBridge']);
        }

        return $query->paginate();
    }

    private function searchWallets(array $parameters): LengthAwarePaginator
    {
        $query = Wallet::query();

        $this->queryValueRange($query, $parameters['balanceFrom'], $parameters['balanceTo']);

        if ($parameters['term']) {
            $query->where('address', $parameters['term']);
            $query->orWhere('public_key', $parameters['term']);
        }

        if ($parameters['username']) {
            $query->where('username', $parameters['username']);
        }

        if ($parameters['vote']) {
            $query->where('vote', $parameters['vote']);
        }

        return $query->paginate();
    }

    private function queryDateRange(Builder $query, ?string $dateFrom, ?string $dateTo): Builder
    {
        if ($dateFrom) {
            $dateFrom = Timestamp::fromUnix(Carbon::parse($dateFrom)->unix())->unix();
        }

        if ($dateTo) {
            $dateTo = Timestamp::fromUnix(Carbon::parse($dateTo)->unix())->unix();
        }

        if ($dateFrom && $dateTo) {
            $query->whereBetween('timestamp', [$dateFrom, $dateTo]);
        } elseif ($dateFrom) {
            $query->where('timestamp', '>=', $dateFrom);
        } elseif ($dateTo) {
            $query->where('timestamp', '<=', $dateTo);
        }

        return $query;
    }

    private function queryValueRange(Builder $query, ?string $from, ?string $to): Builder
    {
        if ($from && $to) {
            $query->whereBetween('total_amount', [$from, $to]);
        } elseif ($from) {
            $query->where('total_amount', '>=', $from);
        } elseif ($to) {
            $query->where('total_amount', '<=', $to);
        }

        return $query;
    }
}
