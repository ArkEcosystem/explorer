@props([
    'optionClass' => '',
    'title',
    'type' => false,
])
<div class="search-advanced-option-wrapper"@if($type) x-show="searchType === '{{ $type }}'"@endif>
    <div class="search-advanced-option {{ $optionClass }}">
        <div class="text-sm font-semibold">{{ $title }}</div>
        <div class="flex items-center">
            {{ $slot }}
        </div>
    </div>
</div>
