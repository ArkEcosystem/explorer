<div class="flex items-center justify-center space-x-2 text-theme-secondary-500">
    @if ($model->isKnown())
        <div data-tippy-content="@lang('labels.verified_address')">
            <x-icon name="app-verified" />
        </div>
    @endif

    @if ($model->hasMultiSignature())
        <div data-tippy-content="@lang('labels.multi_signature')">
            <x-icon name="app.transactions-multi-signature" />
        </div>
    @endif

    @if ($model->isOwnedByExchange())
        <div data-tippy-content="@lang('labels.exchange')">
            <x-icon name="app-exchange" />
        </div>
    @endif

    @if ($model->hasSecondSignature())
        <div data-tippy-content="@lang('labels.second_signature')">
            <x-icon name="app.transactions-second-signature" />
        </div>
    @endif
</div>
