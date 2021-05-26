<div class="bg-white border-t border-theme-secondary-300 dark:border-theme-secondary-800 dark:bg-theme-secondary-900">
    <x-ark-container container-class="flex flex-wrap">
        <div class="mb-8 w-full">
            <h4>@lang('pages.wallet.registrations')</h4>
        </div>

        <div class="flex flex-col w-full divide-y divide-dashed divide-theme-secondary-300 dark:divide-theme-secondary-800">
            <div class="grid grid-cols-1 grid-flow-row gap-y-4 gap-x-6 w-full md:grid-cols-2 details-grid">
                @foreach($wallet->registrations() as $registration)
                    <x-grid.entity :model="$registration" />
                @endforeach
            </div>
        </div>
    </x-ark-container>
</div>
