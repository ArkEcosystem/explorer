<x-general.search.advanced-option :title="trans('forms.search.type')">
    <x-rich-select
        :dispatch-event="'search-type-changed'"
        wire:model.defer="state.type"
        :options="[
            'block' => __('forms.search.block'),
            'transaction' => __('forms.search.transaction'),
            'wallet' => __('forms.search.wallet'),
        ]"
    />
</x-general.search.advanced-option>

<x-general.search.advanced-option :title="trans('forms.search.transaction_type')">
    <x-rich-select
        wire:model.defer="state.transactionType"
        :options="collect(trans('forms.search.transaction_types'))->mapWithKeys(function ($value, $key) {
            return [$key => $value];
        })->toArray()"
    />
    {{-- <select wire:model.defer="state.transactionType" class="w-full font-medium bg-transparent text-theme-secondary-900 dark:text-theme-secondary-200">
        @foreach(trans('forms.search.transaction_types') as $key => $value)
            <option value="{{ $key }}">{{ $value }}</option>
        @endforeach
    </select> --}}
</x-general.search.advanced-option>

<x-general.search.advanced-option :title="trans('forms.search.amount_range')">
    <div class="flex items-center space-x-2">
        <input
            type="number"
            placeholder="0.00"
            class="w-full dark:text-theme-secondary-200 dark:bg-theme-secondary-900"
            wire:model.defer="state.amountFrom"
            wire:key="state_amount_from"
            wire:keydown.enter="performSearch"
        />

        <span>-</span>

        <input
            type="number"
            placeholder="0.00"
            class="w-full dark:text-theme-secondary-200 dark:bg-theme-secondary-900"
            wire:model.defer="state.amountTo"
            wire:key="state_amount_to"
            wire:keydown.enter="performSearch"
        />
    </div>
</x-general.search.advanced-option>

<x-general.search.advanced-option :title="trans('forms.search.fee_range')">
    <div class="flex items-center space-x-2">
        <input
            type="number"
            placeholder="0.00"
            class="w-full dark:text-theme-secondary-200 dark:bg-theme-secondary-900"
            wire:model.defer="state.feeFrom"
            wire:key="state_fee_from"
            wire:keydown.enter="performSearch"
        />

        <span>-</span>

        <input
            type="number"
            placeholder="0.00"
            class="w-full dark:text-theme-secondary-200 dark:bg-theme-secondary-900"
            wire:model.defer="state.feeTo"
            wire:key="state_fee_to"
            wire:keydown.enter="performSearch"
        />
    </div>
</x-general.search.advanced-option>

<x-general.search.advanced-option :title="trans('forms.search.smartbridge')">
    <input
        type="text"
        placeholder="@lang('forms.search.smartbridge_placeholder')"
        class="w-full dark:text-theme-secondary-200 dark:bg-theme-secondary-900"
        wire:model.defer="state.smartBridge"
        wire:keydown.enter="performSearch"
    />
</x-general.search.advanced-option>

<x-general.search.advanced-option :title="trans('forms.search.date_range')">
    <div>
        <input
            type="date"
            class="bg-transparent -ml-7"
            wire:model.defer="state.dateFrom"
            wire:key="state_date_from"
            style="width: 49px;"
        />

        <span>-</span>

        <input
            type="date"
            class="-ml-6 bg-transparent"
            wire:model.defer="state.dateTo"
            wire:key="state_date_to"
            style="width: 49px;"
        />
    </div>
</x-general.search.advanced-option>
