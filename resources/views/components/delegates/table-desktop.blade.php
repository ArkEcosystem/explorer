<div class="hidden w-full table-container md:block">
    <table>
        <thead>
            <tr>
                <th><span class="pl-14">@lang('general.delegates.rank')</span></th>
                <th class="text-right">@lang('general.delegates.name')</th>
                <th class="text-right">@lang('general.delegates.status')</th>
                <th class="text-right">@lang('general.delegates.votes')</th>
                @if (Network::usesMarketSquare())
                <th class="text-right">@lang('general.delegates.profile')</th>
                <th class="text-right">@lang('general.delegates.commission')</th>
                @endif
                <th width="120" class="hidden text-right lg:table-cell">@lang('general.delegates.productivity')</th>
            </tr>
        </thead>
        <tbody>
            @foreach($wallets as $wallet)
                <tr>
                    <td>
                        <div class="flex flex-row items-center space-x-3">
                            <div wire:loading.class="w-6 h-6 rounded-full md:w-11 md:h-11 bg-theme-secondary-300 animate-pulse"></div>
                            <div wire:loading.class="w-full h-5 rounded-full bg-theme-secondary-300 animate-pulse"></div>
                        </div>

                        <x-general.address :address="$wallet->address()" />
                    </td>
                    <td class="text-right">
                        <div wire:loading.class="h-4 rounded-md bg-theme-secondary-300 animate-pulse"></div>

                        <div wire:loading.class="hidden">
                            <x-general.amount-fiat-tooltip :amount="$wallet->balance()" :fiat="$wallet->balanceFiat()" />
                        </div>
                    </td>
                    <td class="hidden text-right lg:table-cell">
                        <div wire:loading.class="h-4 rounded-md bg-theme-secondary-300 animate-pulse"></div>

                        <div wire:loading.class="hidden">
                            {{ $wallet->balancePercentage() }}
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
