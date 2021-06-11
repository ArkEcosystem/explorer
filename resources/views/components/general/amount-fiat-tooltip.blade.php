@props([
    'isSent' => false,
    'isReceived' => false,
    'fiat' => null,
    'amount' => null,
    'amountForItself' => null,
])

@php
    $class = '';

    if($isSent || $isReceived) {
        $class.= ' flex px-1.5 py-1 font-semibold whitespace-nowrap rounded border';
    }

    if($isSent) {
        $class.= ' fiat-tooltip-sent text-theme-danger-400 border-theme-danger-100 dark:border-theme-danger-400';
    }

    if($isReceived) {
        $class.= ' fiat-tooltip-received text-theme-success-600 border-theme-success-200 dark:border-theme-success-600';
    }
@endphp

<span {{ $attributes->merge(['class' => $class]) }}>
    @if($amountForItself !== null && $amountForItself > 0)
        <span class="fiat-hint" data-tippy-content="{{ trans('general.fiat_excluding_itself', [
            'amount' => \Konceiver\BetterNumberFormatter\BetterNumberFormatter::new()->formatWithCurrencyCustom($amountForItself, Network::currency())
        ]) }}">
            <x-ark-icon name="hint" size="xs" />
        </span>
    @endif

    @if(Network::canBeExchanged())
        <span @if ($amount) data-tippy-content="{{ $fiat }}" @endif>
            {{ $isSent ? '-' : ($isReceived ? '+' : '')}}
            <x-currency :currency="Network::currency()">{{ $amount }}</x-currency>
        </span>
    @else
        <span>
            {{ $isSent ? '-' : ($isReceived ? '+' : '')}}
            <x-currency :currency="Network::currency()">{{ $amount }}</x-currency>
        </span>
    @endif
</span>
