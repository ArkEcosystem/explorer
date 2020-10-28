<div id="transaction-list" class="w-full" wire:poll.{{ Network::blockTime() }}s>
    @if ($performedInitialLoad)
        {{-- @TODO: we need to use components here that don't get triggered by wire:loading --}}

        <x-transactions.table-desktop :transactions="$transactions" />

        <x-transactions.list-mobile :transactions="$transactions" />
    @else
        <x-transactions.table-skeleton />
    @endif

    <div class="pt-4 mt-8 border-t border-theme-secondary-300 dark:border-theme-secondary-800 md:mt-0 md:border-dashed">
        <a href="{{ route('transactions') }}" class="w-full button-secondary">@lang('actions.view_all')</a>
    </div>
</div>
