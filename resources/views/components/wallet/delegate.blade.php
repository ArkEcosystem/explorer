<div class="bg-white border-t-20 border-theme-secondary-100 dark:border-black dark:bg-theme-secondary-900">
    <div class="flex-wrap py-16 space-x-4 content-container md:px-8">
        <div class="w-full mb-8">
            <h2 class="text-xl sm:text-2xl">@lang('pages.wallet.delegate.title', [$wallet->username()])</h2>
        </div>

        <div class="flex flex-wrap w-full divide-theme-secondary-300 dark:divide-theme-secondary-800">
            <div class="grid w-full grid-flow-row grid-cols-1 gap-6 pt-8 pb-8 mb-8 border-b border-dashed border-theme-secondary-300 dark:border-theme-secondary-800 md:grid-cols-2 lg:grid-cols-4 gap-y-12 md:gap-y-4">
                <x-details-box :title="trans('pages.wallet.delegate.rank')" icon="app-rank" icon-wrapper-class="bg-theme-danger-100" icon-class="text-theme-danger-400">
                    @if ($wallet->rank() > Network::delegateCount())
                        <x-number>{{ $model->rank() }}</x-number>
                    @else
                        <x-number>{{ $model->rank() }}</x-number> <span class="text-theme-secondary-500 dark:text-theme-secondary-700">/{{ Network::delegateCount() }}</span>
                    @endif
                </x-details-box>

                <x-details-box :title="trans('pages.wallet.delegate.commission')" icon="app-percent" icon-wrapper-class="bg-theme-danger-100" icon-class="text-theme-danger-400">
                    @if($wallet->commission())
                        <x-percentage>{{ $wallet->commission() }}</x-percentage>
                    @else
                        @lang('generic.not_specified')
                    @endif
                </x-details-box>

                <x-details-box :title="trans('pages.wallet.delegate.payout_frequency')" icon="app-price" icon-wrapper-class="bg-theme-danger-100" icon-class="text-theme-danger-400">
                    @if($wallet->payoutFrequency())
                        {{ $wallet->payoutFrequency() }}
                    @else
                        @lang('generic.not_specified')
                    @endif
                </x-details-box>

                <x-details-box :title="trans('pages.wallet.delegate.payout_minimum')" icon="app-min" icon-wrapper-class="bg-theme-danger-100" icon-class="text-theme-danger-400">
                    @if($wallet->payoutMinimum())
                        <x-currency>{{ $wallet->payoutMinimum() }}</x-currency>
                    @else
                        @lang('generic.not_specified')
                    @endif
                </x-details-box>
            </div>

            <div class="grid w-full grid-flow-row grid-cols-1 gap-6 pb-8 border-b border-dashed md:grid-cols-2 lg:grid-cols-4 gap-y-12 md:gap-y-4 border-theme-secondary-300 dark:border-theme-secondary-800">
                <x-details-box :title="trans('pages.wallet.delegate.forged_total')" icon="app-forged" shallow>
                    <x-currency>{{ $wallet->totalForged() }}</x-currency>
                </x-details-box>

                <x-details-box icon="app-transactions.unvote" shallow>
                    <x-slot name="title">
                        @lang('pages.wallet.delegate.votes', [App\Services\NumberFormatter::percentage($wallet->votesPercentage())])
                    </x-slot>

                    <x-currency>{{ $wallet->votes() }}</x-currency>
                    <a href="{{ route('wallet.voters', $wallet->address()) }}" class="link">@lang('general.see_all')</a>
                </x-details-box>

                <x-details-box :title="trans('pages.wallet.delegate.forged_blocks')" icon="app-block-id" shallow>
                    <x-number>{{ $wallet->forgedBlocks() }}</x-number>
                    <a href="{{ route('wallet.blocks', $wallet->address()) }}" class="link">@lang('general.see_all')</a>
                </x-details-box>

                <x-details-box :title="trans('pages.wallet.delegate.productivity')" icon="app-percent" shallow>
                    <x-percentage>{{ $wallet->productivity() }}</x-percentage>
                </x-details-box>
            </div>
        </div>
    </div>
</div>
