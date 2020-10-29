<div class="flex items-center" wire:key="sender:{{ $transaction->id() }}">
    <div class="flex items-center justify-center p-2">
        <div class="flex items-center justify-center w-12 h-12 -mr-2">
            <div class="circled-icon text-theme-secondary-900 border-theme-secondary-900 dark:text-theme-secondary-600 dark:border-theme-secondary-600">
                @if($transaction->isSent($wallet->address()))
                    @svg('app-arrow-down', 'h-5 w-5')
                @else
                    @svg('app-arrow-up', 'h-5 w-5')
                @endif
            </div>
        </div>

        <x-general.avatar :identifier="$transaction->sender()->address()" />
    </div>

    <div class="flex flex-col space-y-2">
        <span class="text-lg font-semibold text-theme-secondary-700">
            <x-general.identity-iconless :model="$transaction->sender()" />
        </span>
    </div>
</div>
