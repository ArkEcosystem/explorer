<div class="bg-white border-t border-theme-secondary-300 dark:border-theme-secondary-800 dark:bg-theme-secondary-900">
    <x-ark-container container-class="flex flex-wrap">
        <div class="flex items-center space-x-4 w-full">
            <h4 class="mb-0 text-2xl leading-normal">
                @lang('pages.wallet.delegate.title', [$wallet->username()])
            </h4>

            @if ($wallet->isResigned())
                <x-details.resigned />
            @endif
        </div>

        <div class="flex flex-wrap w-full sm:flex-nowrap sm:flex-row md:flex-wrap sm:justify-between sm:divide-x md:divide-x-0 divide-theme-secondary-300 dark:divide-theme-secondary-800">
            @if (! $wallet->isResigned())
            <div class="grid grid-cols-1 grid-flow-row gap-6 gap-y-10 pb-8 mb-8 w-full border-b border-dashed sm:pt-8 sm:pt-0 md:pt-8 sm:pb-0 md:pb-8 sm:mb-0 md:mb-8 sm:border-b-0 md:border-b border-theme-secondary-300 dark:border-theme-secondary-800 md:grid-cols-2 lg:grid-cols-4 delegate-details">
                <x-details-box :title="trans('pages.wallet.delegate.rank')" icon="app-rank" icon-wrapper-class="bg-theme-danger-100 dark:bg-theme-danger-400" icon-text-class="text-theme-danger-400 dark:text-theme-secondary-200">
                    @if ($wallet->rank() > Network::delegateCount())
                        <x-number>{{ $wallet->rank() }}</x-number>
                    @else
                        <div class="flex">
                            <span><x-number>{{ $wallet->rank() }}</x-number></span>
                            <span class="text-theme-secondary-500 dark:text-theme-secondary-200">/{{ Network::delegateCount() }}</span>
                        </div>
                    @endif
                </x-details-box>

                    {{--TODO: Remove --}}
                    <x-details-box :title="trans('pages.wallet.delegate.commission')" icon="app-percent" icon-wrapper-class="bg-theme-danger-100 dark:bg-theme-danger-400" icon-text-class="text-theme-danger-400 dark:text-theme-secondary-200">
                        @lang('generic.not_specified')
                    </x-details-box>

                    {{--TODO: Remove --}}
                    <x-details-box :title="trans('pages.wallet.delegate.payout_frequency')" icon="app-price" icon-wrapper-class="bg-theme-danger-100 dark:bg-theme-danger-400" icon-text-class="text-theme-danger-400 dark:text-theme-secondary-200">
                        @lang('generic.not_specified')
                    </x-details-box>

                    {{--TODO: Remove --}}
                    <x-details-box :title="trans('pages.wallet.delegate.payout_minimum')" icon="app-min" icon-wrapper-class="bg-theme-danger-100 dark:bg-theme-danger-400" icon-text-class="text-theme-danger-400 dark:text-theme-secondary-200">
                        @lang('generic.not_specified')
                    </x-details-box>
                </div>
            @endif

            <div class="grid grid-cols-1 grid-flow-row gap-6 gap-y-10 pb-8 w-full border-b border-dashed sm:pb-0 md:py-8 sm:border-b-0 md:border-b md:grid-cols-2 lg:grid-cols-4 border-theme-secondary-300 dark:border-theme-secondary-800 delegate-details sm:pl-8 md:pl-0">
                <x-details-box :title="trans('pages.wallet.delegate.forged_total')" icon="app-forged" shallow>
                    <x-general.currency-with-tooltip>
                        {{ $wallet->totalForged() }}
                    </x-general.currency-with-tooltip>
                </x-details-box>

                <x-details-box icon="app-transactions.unvote" shallow>
                    <x-slot name="title">
                        @lang('pages.wallet.delegate.votes', [App\Services\NumberFormatter::percentage($wallet->votesPercentage())])
                    </x-slot>

                    <x-general.currency-with-tooltip>
                        {{ $wallet->votes() }}
                    </x-general.currency-with-tooltip>

                    <a href="{{ route('wallet.voters', $wallet->address()) }}" class="link">@lang('general.see_all')</a>
                </x-details-box>

                <x-details-box :title="trans('pages.wallet.delegate.forged_blocks')" icon="app-block-id" shallow>
                    <x-number>{{ $wallet->blocksForged() }}</x-number>
                    <a href="{{ route('wallet.blocks', $wallet->address()) }}" class="link">@lang('general.see_all')</a>
                </x-details-box>

                <x-details-box :title="trans('pages.wallet.delegate.productivity')" icon="app-percent" shallow>
                    N/A
                    {{-- <x-percentage>{{ $wallet->productivity() }}</x-percentage> --}}
                </x-details-box>
            </div>
        </div>
    </x-ark-container>
</div>
