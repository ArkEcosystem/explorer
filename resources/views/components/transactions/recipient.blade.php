@php($iconType = $transaction->iconType())

<div>
    @if ($iconType === 'unknown')
        <x-general.address :address="$transaction->recipient() ?? $transaction->sender()" />
    @elseif ($iconType === "vote")
        <x-general.address :address="$transaction->voted()">
            <x-slot name="icon">
                <div class="transaction-icon">
                    @svg('app-transactions.'.$iconType, 'w-4 h-4')
                </div>
            </x-slot>

            <x-slot name="prefix">
                <span class="pr-2 mr-2 font-semibold border-r border-theme-secondary-300 dark:border-theme-secondary-800">
                    @lang('general.transaction.vote')
                </span>
            </x-slot>
        </x-general.address>
    @elseif ($iconType === "unvote")
        <x-general.address :address="$transaction->unvoted()">
            <x-slot name="icon">
                <div class="transaction-icon">
                    @svg('app-transactions.'.$iconType, 'w-4 h-4')
                </div>
            </x-slot>

            <x-slot name="prefix">
                <span class="pr-2 mr-2 font-semibold border-r border-theme-secondary-300 dark:border-theme-secondary-800">
                    @lang('general.transaction.unvote')
                </span>
            </x-slot>
        </x-general.address>
    @else
        <div class="flex items-center space-x-3">
            <div class="transaction-icon">
                @svg('app-transactions.'.$iconType, 'w-4 h-4')
            </div>

            <div class="font-semibold">@lang('general.transaction.vote-combination')</div>
        </div>
    @endif
</div>
