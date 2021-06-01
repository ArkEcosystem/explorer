@props([
    'name',
    'first' => null,
])

<button
    type="button"
    class="relative px-2 cursor-pointer ml-14 explorer-tab transition-default hover:text-theme-secondary-900 dark:hover:text-theme-secondary-200"
    @click="select('{{ $name }}')"
    @keydown.enter="select('{{ $name }}')"
    @keydown.space.prevent="select('{{ $name }}')"
    role="tab"
    id="tab-{{ $name }}"
    aria-controls="panel-{{ $name }}"
    wire:key="tab-{{ $name }}"
    @keydown.arrow-left="selectPrevTab"
    @keydown.arrow-right="selectNextTab"
    :tabindex="selected === '{{ $name }}' ? 0 : -1"
    :aria-selected="selected === '{{ $name }}'"
    {{ $attributes }}
>
    <span
        class="block w-full h-full pt-4 pb-3 border-b-4 whitespace-nowrap"
        :class="{
            'border-transparent dark:text-theme-secondary-500 ': selected !== '{{ $name }}',
            'text-theme-secondary-900 border-theme-primary-600 dark:text-theme-secondary-200 font-semibold': selected === '{{ $name }}',
        }"
    >{{ $slot }}</span>
</button>

