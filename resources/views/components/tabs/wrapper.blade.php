@props([
    'onSelected' => null,
    'defaultSelected' => ''
])

<div
    {{ $attributes->merge(['class' => 'items-center justify-between hidden w-full md:flex bg-theme-secondary-100 rounded-xl dark:bg-black' ])}}
    x-data="{
        selected: '{{ $defaultSelected }}',
        select(name) {
            this.selected = name;

            this.onSelected(name);
        },
        @if($onSelected)
            onSelected: {{ $onSelected }},
        @else
            onSelected: () => {},
        @endif
    }"
>
    <div class="flex">
        {{ $slot }}
    </div>

    @isset($right)
        {{ $right }}
    @endisset
</div>
