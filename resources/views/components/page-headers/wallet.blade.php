<x-page-headers.wallet.frame title="pages.wallet.title" :wallet="$wallet">
    <x-page-headers.wallet.frame-item icon="wallet">
        <x-slot name="title">
            @lang('pages.wallet.balance')@if(Network::canBeExchanged()): {{ $wallet->balanceFiat() }}@endif
        </x-slot>

        <x-currency :currency="Network::currency()">{{ $wallet->balance() }}</x-currency>
    </x-page-headers.wallet.frame-item>

    @if($wallet->isDelegate())
        @php
            $firstColor = ($wallet->isResigned() ? 'text-theme-secondary-500 border-theme-secondary-500' : ($wallet->rank() > 51 ?
            'text-theme-secondary-900 border-theme-secondary-900' : 'text-theme-secondary-900 border-theme-secondary-900'));

            $secondColor = ($wallet->isResigned() ? 'text-theme-secondary-500 border-theme-secondary-500' : ($wallet->rank() > 51 ?
            'text-theme-secondary-500 border-theme-secondary-500' : 'text-theme-success-600 border-theme-success-600'));

            $vote = $wallet->vote()
        @endphp
        <x-slot name="extension">
            <div class="grid grid-flow-row justify-between space-y-2 lg:grid-flow-col sm:space-y-6 lg:space-y-0">
                <div class="flex flex-col space-y-2 sm:flex-row sm:space-y-0 entity-header">
                    <div class="w-48 h-11 md:w-64 lg:w-auto">
                        <x-general.entity-header-item
                            title="{{ trans('pages.wallet.delegate.rank') }} / {{ trans('pages.wallet.delegate.status') }}"
                            without-single-icon
                            with-multiple-icons
                            first-icon="app-rank"
                            :first-icon-colors="$firstColor"
                            second-icon="{{ $wallet->rank() > 51 ? 'clock' : 'checkmark-smooth' }}"
                            :second-icon-colors="$secondColor"
                            :identifier="$vote"
                        >
                            <x-slot name="text">
                                @if(! $wallet->isResigned())
                                    # {{ $wallet->rank() }} /
                                @endif
                                @if($wallet->isResigned())
                                    <span class="text-theme-danger-400">@lang('pages.delegates.resigned')</span>
                                @elseif($wallet->rank() > 51)
                                    <span class="text-theme-secondary-500">@lang('pages.delegates.standby')</span>
                                @else
                                    <span class="text-theme-success-600">@lang('pages.delegates.active')</span>
                                @endif
                            </x-slot>
                        </x-general.entity-header-item>
                    </div>

                    @if (! $wallet->isResigned())
                        <div class="w-48 h-11 md:w-64 lg:w-auto">
                            <x-general.entity-header-item
                                :title="trans('pages.wallet.productivity')"
                                :tooltip="trans('pages.wallet.productivity_tooltip')"
                                without-single-icon
                            >
                                <x-slot name="text">
                                    <span @if($wallet->rank() > 51)class="text-theme-secondary-500"@endif>
                                        <x-percentage>{{ $wallet->productivity() }}</x-percentage>
                                    </span>
                                </x-slot>
                            </x-general.entity-header-item>
                        </div>
                    @endif

                    <div class="w-48 h-11 md:w-64 lg:w-auto">
                        <x-general.entity-header-item
                            :title="trans('pages.wallet.delegate.forged_total')"
                            without-single-icon
                        >
                            <x-slot name="text">
                                <span @if($wallet->isResigned())class="text-theme-secondary-500"@endif>
                                    <x-number>{{ $wallet->blocksForged() }}</x-number>
                                    {{ Network::currency() }}
                                </span>
                            </x-slot>
                        </x-general.entity-header-item>
                    </div>
                </div>

                <div class="flex flex-col space-y-2 sm:flex-row sm:space-y-0 entity-header">
                    <div class="w-48 h-11 md:w-64 lg:w-auto">
                        <x-general.entity-header-item
                            :title="trans('pages.wallet.delegate.forged_blocks')"
                            :text="trans('general.see_all')"
                            :url="route('wallet.blocks', $wallet->address())"
                            text-class="w-full lg:text-right"
                            without-single-icon
                        />
                    </div>
                    <div class="w-48 h-11 md:w-64 lg:w-auto">
                        <x-general.entity-header-item
                            :title="trans('pages.wallet.delegate.votes', [App\Services\NumberFormatter::kNotationCurrency($wallet->votes())])"
                            :text="trans('general.see_all')"
                            :url="route('wallet.voters', $wallet->address())"
                            text-class="w-full lg:text-right"
                            without-single-icon
                        />
                    </div>
                </div>
            </div>
        </x-slot>
    @endif
</x-page-headers.wallet.frame>