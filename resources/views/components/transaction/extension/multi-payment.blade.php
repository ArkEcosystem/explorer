<div class="bg-white border-t border-theme-secondary-300 dark:border-theme-secondary-800 dark:bg-theme-secondary-900">
    <x-ark-container>
        <div class="w-full">
            <div class="flex relative justify-between items-end mb-3">
                <h4 class="text-2xl">@lang('pages.transaction.recipient_list')</h4>
            </div>


            <x-tables.payments :payments="$transaction->payments()" />
        </div>
    </x-ark-container>
</div>
