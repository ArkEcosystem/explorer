<div class="bg-white border-t border-theme-secondary-300 dark:border-theme-secondary-800 dark:bg-theme-secondary-900">
    <x-ark-container>
        <div class="w-full">
            <div class="relative flex items-end justify-between">
                <h4 class="text-2xl">@lang('pages.transaction.participants')</h4>
            </div>

            <x-ark-tables.table class="hidden md:block">
                <thead>
                    <tr>
                        <x-tables.headers.desktop.id name="#" />
                        <x-tables.headers.desktop.address name="general.wallet.address" />
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaction->participants() as $participant)
                        <x-ark-tables.row>
                            <x-ark-tables.cell>
                                {{ $loop->index + 1}}
                            </x-ark-tables.cell>
                            <x-ark-tables.cell>
                                <x-tables.rows.desktop.address :model="$participant"/>
                            </x-ark-tables.cell>
                        </x-ark-tables.row>
                    @endforeach
                </tbody>
            </x-ark-tables.table>

            <div class="divide-y md:hidden table-list-mobile">
                @foreach($transaction->participants() as $participant)
                    <div class="space-y-3 table-list-mobile-row">
                        <div>
                            #

                            <span>{{ $loop->index + 1}}</span>
                        </div>

                        <x-tables.rows.mobile.address :model="$participant" />
                    </div>
                @endforeach
            </div>
        </div>
    </x-ark-container>
</div>
