@props([
    'id',
    'data',
    'labels',
    'canvasClass' => 'w-full h-full',
    'width' => '1000',
    'height' => '500',
    'grid' => false,
    'tooltips' => false,
    'theme' => collect(['name' => 'grey', 'mode' => 'light']),
])

<div
    x-data="ChartLine(
        '{{ $id }}',
        {{ $data }},
        {{ $labels }},
        '{{ $grid }}',
        '{{ $tooltips }}',
        {{ $theme }},
        '{{ $height }}',
        '{{ time() }}'
    )"
    x-init="init"
    @toggle-dark-mode.window="updateChart"
    @stats-period-updated.window="updateChart"
    wire:key="{{ $id.time() }}"
    {{ $attributes->only('class') }}
>
    <div wire:ignore>
        <canvas
            x-ref="{{ $id }}"
            @if($canvasClass) class="{{ $canvasClass }}" @endif
            @if($width) width="{{ $width }}" @endif
            @if($height) height="{{ $height }}" @endif
        ></canvas>
    </div>
</div>
