<div class="hidden table-container w-full md:block">
    <table>
        <thead>
            <tr>
                <th><span class="pl-14">@lang('general.wallet.address')</span></th>
                <th class="text-center">@lang('general.wallet.info')</th>
                <th class="text-right">@lang('general.wallet.balance')</th>
                <th class="hidden text-right lg:table-cell">@lang('general.wallet.supply')</th>
            </tr>
        </thead>
        <tbody>
            @foreach($wallets as $wallet)
                <tr>
                    <td><x-general.address :address="$wallet->address()" /></td>
                    <td class="text-center">
                        <div class="flex items-center justify-center text-theme-secondary-500 space-x-2">
                            @if ($wallet->isKnown())
                                <div data-tippy-content="@lang('general.verified_address')">
                                    @svg('app-verified', 'w-5 h-5')
                                </div>
                            @endif

                            @if ($wallet->isOwnedByExchange())
                                <div data-tippy-content="@lang('general.exchange')">
                                    @svg('app-exchange', 'w-5 h-5')
                                </div>
                            @endif
                        </div>
                    </td>
                    <td class="text-right">{{ $wallet->balance() }}</td>
                    <td class="hidden text-right lg:table-cell">{{ number_format($wallet->balancePercentage(), 2) }} %</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
