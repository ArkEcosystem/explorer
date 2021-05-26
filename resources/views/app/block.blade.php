@component('layouts.app', ['isLanding' => true, 'fullWidth' => true])

    @push('scripts')
        <script src="{{ mix('js/clipboard.js')}}"></script>
    @endpush

    @section('content')
        <x-page-headers.block :block="$block" />

        <x-details.grid>
            <x-grid.height :model="$block" />

            <x-grid.timestamp :model="$block" />

            <x-grid.reward :model="$block" />

            <x-grid.fee :model="$block" />

            <x-grid.confirmations :model="$block" />
        </x-details.grid>

        @if($hasTransactions)
            <div class="bg-white border-t border-theme-secondary-300 dark:border-theme-secondary-800 dark:bg-theme-secondary-900">
                <x-ark-container>
                    <div id="transaction-list" class="w-full">
                        <div class="relative flex items-end justify-between mb-8">
                            <h4>@lang('pages.block.transactions')</h4>
                        </div>

                        <livewire:block-transactions-table :block-id="$block->id()" />
                    </div>
                </x-ark-container>
            </div>
        @endif
    @endsection

@endcomponent
