<div class="space-y-8 divide-y table-list-mobile">
    @foreach ($payments as $payment)
        <div class="space-y-3 table-list-mobile-row">
            <div>
                @lang('general.transaction.recipient')

                <div class="flex flex-row items-center space-x-3">
                    <div wire:loading.class="h-6 rounded-full w-11 bg-theme-secondary-300 animate-pulse"></div>
                    <div wire:loading.class="w-full h-5 rounded-full bg-theme-secondary-300 animate-pulse"></div>
                </div>

                <x-general.address :address="$payment['recipientId']" />
            </div>

            <div>
                @lang('general.transaction.amount')

                <div wire:loading.class="w-full h-5 rounded-full bg-theme-secondary-300 animate-pulse"></div>

                <div wire:loading.class="hidden">
                    {{ $payment['amount'] }}
                </div>
            </div>
        </div>
    @endforeach
</div>
