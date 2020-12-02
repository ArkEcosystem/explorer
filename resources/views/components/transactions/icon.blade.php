@if($compact)
    <div class="borderless-transaction-icon">
        <x-ark-icon :name="'app-transactions.'. $iconType" size="sm" class="object-cover" />
    </div>
@else
    <div class="transaction-icon">
        <x-ark-icon :name="'app-transactions.'. $iconType" size="md" class="md:w-5 md:h-5" />
    </div>
@endif
