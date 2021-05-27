<x-page-headers.wallet.frame title="pages.wallet.title" :wallet="$wallet">
    <x-page-headers.wallet.frame-item icon="wallet" title-class="whitespace-nowrap">
        <x-slot name="title">
            @lang('pages.wallet.balance')@if(Network::canBeExchanged()): <livewire:wallet-balance :wallet="$wallet->model()" /> @endif
        </x-slot>

        <x-currency :currency="Network::currency()">{{ $wallet->balance() }}</x-currency>
    </x-page-headers.wallet.frame-item>

    @if($wallet->isDelegate())
        @php
            $isResigned = $wallet->isResigned();
            $isStandby = $wallet->rank() > Network::delegateCount();
            $vote = $wallet->vote()
        @endphp

        <x-slot name="extension">
            <div class="grid space-y-4 w-full sm:grid-rows-2 lg:flex lg:justify-between sm:space-y-4 lg:space-y-0">
                <div class="grid grid-cols-1 space-y-4 sm:grid-cols-3 lg:flex sm:space-y-0 lg:space-x-5 sm:h-11 lg:h-auto">
                    <x-general.header-entry
                        title="{{ trans('pages.wallet.delegate.rank') }} / {{ trans('pages.wallet.delegate.status') }}"
                    >
                        <x-slot name="icon">
                            <div class="flex items-center md:mr-2">
                                <x-page-headers.icon-with-icon
                                    first-icon="app-rank"
                                    :first-icon-colors="$wallet->delegateStatusColors()->first()"
                                    second-icon="{{ $isStandby ? 'clock' : 'checkmark-smooth' }}"
                                    :second-icon-colors="$wallet->delegateStatusColors()->last()"
                                />
                            </div>
                        </x-slot>

                        <x-slot name="text">
                            @if(! $isResigned)
                                # {{ $wallet->rank() }} /
                            @endif
                            @if($isResigned)
                                <span class="text-theme-danger-400">@lang('pages.delegates.resigned')</span>
                            @elseif($isStandby)
                                <span class="text-theme-secondary-500">@lang('pages.delegates.standby')</span>
                            @else
                                <span class="text-theme-success-600">@lang('pages.delegates.active')</span>
                            @endif
                        </x-slot>
                    </x-general.header-entry>

                    @if (! $isResigned)
                        <x-general.header-entry
                            :title="trans('pages.wallet.productivity')"
                            :tooltip="trans('pages.wallet.productivity_tooltip')"
                        >
                            <x-slot name="text">
                                <span @if($isStandby)class="text-theme-secondary-500" @endif>
                                    {{--TODO: Change once productivity is properly implemented }}
                                    {{--<x-percentage>{{ $wallet->productivity() }}</x-percentage>--}}
                                    @lang('generic.not-available')
                                </span>
                            </x-slot>
                        </x-general.header-entry>
                    @endif

                    <x-general.header-entry
                        :title="trans('pages.wallet.delegate.forged_total')"
                        without-border
                    >
                        <x-slot name="text">
                            <span @if($isResigned)class="text-theme-secondary-500" @endif>
                                <x-number>{{ $wallet->totalForged() }}</x-number>
                                {{ Network::currency() }}
                            </span>
                        </x-slot>
                    </x-general.header-entry>
                </div>

                <div class="grid grid-cols-1 space-y-4 sm:grid-cols-3 lg:flex sm:space-y-0 lg:space-x-5 sm:h-11 lg:h-auto">
                    <x-general.header-entry
                        :title="trans('pages.wallet.delegate.forged_blocks')"
                        :text="trans('general.see_all')"
                        :url="route('wallet.blocks', $wallet->address())"
                    >
                        <x-slot name="icon">
                            <div class="md:w-11 md:mr-4 lg:w-0 lg:mr-0"></div>
                        </x-slot>
                    </x-general.header-entry>

                    <x-general.header-entry
                        :title="trans('pages.wallet.delegate.votes', [App\Services\NumberFormatter::currencyShortNotation($wallet->votes())])"
                        :text="trans('general.see_all')"
                        :url="route('wallet.voters', $wallet->address())"
                        without-border
                    />
                </div>
            </div>
        </x-slot>
    @endif
</x-page-headers.wallet.frame>