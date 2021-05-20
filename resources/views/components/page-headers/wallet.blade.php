<x-page-headers.wallet.frame title="pages.wallet.title" :wallet="$wallet">
    <x-page-headers.wallet.frame-item icon="wallet">
        <x-slot name="title">
            @lang('pages.wallet.balance')@if(Network::canBeExchanged()): {{ $wallet->balanceFiat() }}@endif
        </x-slot>

        <x-currency :currency="Network::currency()">{{ $wallet->balance() }}</x-currency>
    </x-page-headers.wallet.frame-item>

    @if($wallet->isDelegate())
        @php
            $isResigned = $wallet->isResigned();
            $isStandby = $wallet->rank() > 51;

            $firstColor = ($isResigned ? 'text-theme-secondary-500 border-theme-secondary-500' : ($isStandby ?
            'text-theme-secondary-900 border-theme-secondary-900' : 'text-theme-secondary-900 border-theme-secondary-900'));

            $secondColor = ($isResigned ? 'text-theme-secondary-500 border-theme-secondary-500' : ($isStandby ?
            'text-theme-secondary-500 border-theme-secondary-500' : 'text-theme-success-600 border-theme-success-600'));

            $vote = $wallet->vote()
        @endphp
        <x-slot name="extension">
            <div class="grid grid-flow-row gap-y-5 lg:justify-between lg:grid-flow-col">
                <div class="grid grid-cols-1 {{ $isResigned ? 'sm:grid-cols-2' : 'sm:grid-cols-3' }} gap-y-5 entity-header">
                    <div class="h-11">
                        <x-general.entity-header-item
                            title="{{ trans('pages.wallet.delegate.rank') }} / {{ trans('pages.wallet.delegate.status') }}"
                            without-single-icon
                            with-multiple-icons
                            first-icon="app-rank"
                            :first-icon-colors="$firstColor"
                            second-icon="{{ $isStandby ? 'clock' : 'checkmark-smooth' }}"
                            :second-icon-colors="$secondColor"
                            :identifier="$vote"
                        >
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
                        </x-general.entity-header-item>
                    </div>

                    @if (! $isResigned)
                        <div class="h-11">
                            <x-general.entity-header-item
                                :title="trans('pages.wallet.productivity')"
                                :tooltip="trans('pages.wallet.productivity_tooltip')"
                                without-single-icon
                            >
                                <x-slot name="text">
                                    <span @if($isStandby)class="text-theme-secondary-500"@endif>
                                        <x-percentage>{{ $wallet->productivity() }}</x-percentage>
                                    </span>
                                </x-slot>
                            </x-general.entity-header-item>
                        </div>
                    @endif

                    <div class="h-11">
                        <x-general.entity-header-item
                            :title="trans('pages.wallet.delegate.forged_total')"
                            without-single-icon
                        >
                            <x-slot name="text">
                                <span @if($isResigned)class="text-theme-secondary-500"@endif>
                                    <x-number>{{ $wallet->blocksForged() }}</x-number>
                                    {{ Network::currency() }}
                                </span>
                            </x-slot>
                        </x-general.entity-header-item>
                    </div>
                </div>

                <div class="grid grid-cols-1 {{ $isResigned ? 'sm:grid-cols-2' : 'sm:grid-cols-3' }} lg:grid-cols-2 gap-y-5 entity-header">
                    <div class="h-11">
                        <x-general.entity-header-item
                            :title="trans('pages.wallet.delegate.forged_blocks')"
                            :text="trans('general.see_all')"
                            :url="route('wallet.blocks', $wallet->address())"
                            content-class="flex flex-col flex-1 justify-between font-semibold truncate lg:text-right ml-4 lg:ml-0 w-full sm:pr-4"
                            title-wrapper-class="lg:justify-end"
                            without-single-icon
                            text-class="w-full lg:text-right"
                        />
                    </div>
                    <div class="h-11">
                        <x-general.entity-header-item
                            :title="trans('pages.wallet.delegate.votes', [App\Services\NumberFormatter::kNotationCurrency($wallet->votes())])"
                            :text="trans('general.see_all')"
                            :url="route('wallet.voters', $wallet->address())"
                            content-class="flex flex-col flex-1 justify-between font-semibold truncate lg:text-right ml-4 lg:ml-0 w-full"
                            title-wrapper-class="lg:justify-end"
                            without-single-icon
                            text-class="w-full lg:text-right"
                        />
                    </div>
                </div>
            </div>
        </x-slot>
    @endif
</x-page-headers.wallet.frame>