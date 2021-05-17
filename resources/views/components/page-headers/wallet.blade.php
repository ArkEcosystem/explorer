<x-page-headers.wallet.frame title="pages.wallet.title" :wallet="$wallet">
    <x-page-headers.wallet.frame-item icon="wallet">
        <x-slot name="title">
            @lang('pages.wallet.balance')@if(Network::canBeExchanged()): {{ $wallet->balanceFiat() }}@endif
        </x-slot>

        <x-currency :currency="Network::currency()">{{ $wallet->balance() }}</x-currency>
    </x-page-headers.wallet.frame-item>

    @if($wallet->isDelegate())
        @php($vote = $wallet->vote())
        <x-slot name="extension">
            <div class="flex flex-col space-y-4 sm:space-y-0 sm:grid sm:grid-cols-auto sm:gap-4 entity-header">
                <div class="sm:col-start-1 flex">
                    <x-general.entity-header-item
                        title="{{ trans('pages.wallet.delegate.rank') }} / {{ trans('pages.wallet.delegate.status') }}"
                        icon="checkmark-smooth"
                        icon-colors="@if($wallet->isDelegate) text-theme-success-600 border-theme-success-600 @endif"
                        icon-breakpoint="hidden md:flex"
                    >
                        <x-slot name="text">
                            # {{ $wallet->rank() }} /
                            @if($wallet->isResigned())
                                <span class="text-theme-danger-400">@lang('pages.delegates.resigned')</span>
                            @elseif($wallet->isDelegate())
                                <span class="text-theme-success-600">@lang('pages.delegates.active')</span>
                            @else
                                <span class="text-theme-secondary-500">@lang('pages.delegates.standby')</span>
                            @endif
                        </x-slot>
                    </x-general.entity-header-item>
                </div>

                <div class="sm:col-start-2">
                    <x-general.entity-header-item
                        :title="trans('pages.wallet.productivity')"
                        :tooltip="trans('pages.wallet.productivity_tooltip')"
                        without-icon
                    >
                        <x-slot name="text">
                            <x-percentage>{{ $wallet->productivity() }}</x-percentage>
                        </x-slot>
                    </x-general.entity-header-item>
                </div>

                <div class="sm:col-start-3">
                    <x-general.entity-header-item
                        :title="trans('pages.wallet.delegate.forged_total')"
                        without-icon
                    >
                        <x-slot name="text">
                            <x-number>{{ $wallet->blocksForged() }}</x-number>
                            {{ Network::currency() }}
                        </x-slot>
                    </x-general.entity-header-item>
                </div>

                <div class="sm:col-start-1 lg:col-start-5">
                    <x-general.entity-header-item :title="trans('pages.wallet.delegate.forged_blocks')"
                        :text="trans('general.see_all')" :url="route('wallet.blocks', $wallet->address())"
                        without-icon
                    />
                </div>
                <div class="sm:col-start-2 lg:col-start-6">
                    <x-general.entity-header-item
                        :title="trans('pages.wallet.delegate.votes', [App\Services\NumberFormatter::format_number_in_k_notation($wallet->votes())])"
                        :text="trans('general.see_all')" :url="route('wallet.voters', $wallet->address())"
                        without-icon
                    />
                </div>
            </div>
        </x-slot>
    @endif
</x-page-headers.wallet.frame>