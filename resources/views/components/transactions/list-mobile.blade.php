<div class="space-y-8 divide-y table-list-mobile">
    @foreach ($transactions as $transaction)
        <div class="table-list-mobile-row">
            <table>
                <tr>
                    <td width="150">@lang('general.transaction.id')</td>
                    <td>
                        <div wire:loading.class="w-full h-4 bg-theme-secondary-300 rounded-md animate-pulse"></div>
                        <a href="{{ $transaction->url() }}" class="font-semibold link" wire:loading.class="hidden">
                            <x-truncate-middle :value="$transaction->id()" />
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>@lang('general.transaction.timestamp')</td>
                    <td>
                        <div wire:loading.class="w-full h-4 bg-theme-secondary-300 rounded-md animate-pulse"></div>
                        {{--TODO: Everything disappear once we apply the wire:loading.class here, need to check, might just be me locally --}}
                        <span wire:loading.class="hidden">{{ $transaction->timestamp() }}</span>
                    </td>
                </tr>
                <tr>
                    <td>@lang('general.transaction.sender')</td>
                    <td>
                        <div class="flex flex-row items-center space-x-3">
                            <div wire:loading.class="w-11 h-6 bg-theme-secondary-300 rounded-full animate-pulse"></div>
                            <div wire:loading.class="w-full h-5 bg-theme-secondary-300 rounded-full animate-pulse"></div>
                        </div>

                        <x-general.address :address="$transaction->sender()" />
                    </td>
                </tr>
                <tr>
                    <td>@lang('general.transaction.recipient')</td>
                    <td>
                        <div class="flex flex-row items-center space-x-3">
                            <div wire:loading.class="w-11 h-6 bg-theme-secondary-300 rounded-full animate-pulse"></div>
                            <div wire:loading.class="w-full h-5 bg-theme-secondary-300 rounded-full animate-pulse"></div>
                        </div>

                        <x-general.address :address="$transaction->recipient() ?? $transaction->sender()" />
                    </td>
                </tr>
                <tr>
                    <td>@lang('general.transaction.amount')</td>
                    <td>
                        <div wire:loading.class="w-full h-4 bg-theme-secondary-300 rounded-md animate-pulse"></div>

                        <div wire:loading.class="hidden">
                            <x-general.amount-fiat-tooltip :amount="$transaction->amount()" :fiat="$transaction->amountFiat()" />
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>@lang('general.transaction.fee')</td>
                    <td>
                        <div wire:loading.class="w-full h-4 bg-theme-secondary-300 rounded-md animate-pulse"></div>

                        <div wire:loading.class="hidden">
                            <x-general.amount-fiat-tooltip :amount="$transaction->fee()" :fiat="$transaction->feeFiat()" />
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    @endforeach
</div>
