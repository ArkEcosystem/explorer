<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Models\Block;
use App\Models\Scopes\OrderByAmountScope;
use App\Models\Scopes\OrderByFeeScope;
use App\Models\Scopes\OrderByIdScope;
use App\Models\Scopes\OrderByRecipientScope;
use App\Models\Scopes\OrderBySenderScope;
use App\Models\Scopes\OrderByTimestampScope;
use App\ViewModels\ViewModelFactory;
use ARKEcosystem\UserInterface\Http\Livewire\Concerns\HasPagination;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class BlockTransactionsTable extends Component
{
    use HasPagination;

    public string $blockId;

    public array $state = [
        'transactionsOrdering'          => 'timestamp',
        'transactionsOrderingDirection' => 'desc',
    ];

    /** @phpstan-ignore-next-line */
    protected $listeners = [
        'orderTransactionsBy',
    ];

    public function orderTransactionsBy(string $value): void
    {
        $this->state['transactionsOrdering'] = $value;

        $this->state['transactionsOrderingDirection'] = $this->state['transactionsOrderingDirection'] === 'desc' ? 'asc' : 'desc';

        $this->gotoPage(1);
    }

    public function mount(string $blockId): void
    {
        $this->blockId = $blockId;

        $this->state = array_merge([
            'transactionsOrdering'          => 'timestamp',
            'transactionsOrderingDirection' => 'desc',
        ], request('state', []));
    }

    public function getBlock(): Block
    {
        return Block::findOrFail($this->blockId);
    }

    public function render(): View
    {
        /** @phpstan-ignore-next-line */
        $query = $this->getBlock()->transactions()->scoped($this->getOrderingScope(), $this->state['transactionsOrderingDirection']);

        return view('livewire.transaction-table', [
            'transactions' => ViewModelFactory::paginate($query->paginate(25)),
        ]);
    }

    private function getOrderingScope(): string
    {
        $scopes = [
            'id'        => OrderByIdScope::class,
            'timestamp' => OrderByTimestampScope::class,
            'sender'    => OrderBySenderScope::class,
            'recipient' => OrderByRecipientScope::class,
            'amount'    => OrderByAmountScope::class,
            'fee'       => OrderByFeeScope::class,
        ];

        return $scopes[$this->state['transactionsOrdering']];
    }
}
