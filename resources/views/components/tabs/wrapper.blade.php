@props([
    'onSelected' => null,
    'defaultSelected' => ''
])

<div
    {{ $attributes->merge(['class' => 'items-center justify-between w-full flex bg-theme-secondary-100 rounded-xl dark:bg-black relative z-10' ])}}
    x-data="{
        selected: '{{ $defaultSelected }}',
        select(name) {
            this.selected = name;

            this.onSelected(name);
        },
        selectPrevTab(e) {
            const el = e.target;
            const wrapper = el.parentElement;
            let = prevTab = el;
            do {
                prevTab = prevTab.previousElementSibling;
                if (prevTab === null) {
                    prevTab = wrapper.querySelector('[role=tab]:last-child');
                }
            } while(! prevTab.matches('[role=tab]'));
            prevTab.focus();
        },
        selectNextTab(e) {
            const el = e.target;
            const wrapper = el.parentElement;
            let = nextTab = el;
            do {
                nextTab = nextTab.nextElementSibling;
                if (nextTab === null) {
                    nextTab = wrapper.querySelector('[role=tab]');
                }
            } while(! nextTab.matches('[role=tab]'));
            nextTab.focus();
        },
        @if($onSelected)
            onSelected: {{ $onSelected }},
        @else
            onSelected: () => {},
        @endif
    }"
>
    <div role="tablist" class="flex">
        {{ $slot }}
    </div>

    <div>
        @isset($right)
            {{ $right }}
        @endisset
    </div>
</div>
