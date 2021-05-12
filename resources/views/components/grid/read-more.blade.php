@props([
    'icon',
    'title',
    'content',
])

@php
$content=$content.' a adsd as das maimi mi m in in ininoon aonp asnpd ';
@endphp

<x-grid.generic
    :title="$title"
    :icon="$icon"
    class="transition-none"
>
    <x-ark-read-more :content="$content" />
</x-grid.generic>
