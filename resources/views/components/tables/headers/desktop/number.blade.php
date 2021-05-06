@php($withOrdering = $attributes->get('with-ordering'))

@isset($responsive)
    <th
        class="hidden {{ $breakpoint ?? 'lg'}}:table-cell text-right @if($withOrdering) cursor-pointer @endif"
        {{ $attributes->except(['class', 'breakpoint', 'responsive']) }}
    >
        <div class="flex flex-row items-center">
            @lang($name)

            @if($withOrdering)
                <x-ark-icon name="{{ $this->renderDirectionIcon($name) }}" size="xs" class="ml-2 w-2 h-2" />
            @endif
        </div>
    </th>
@else
    <th
        class="text-right @if($withOrdering) cursor-pointer @endif"
        {{ $attributes->except(['class', 'breakpoint', 'responsive']) }}
    >
        @isset ($slot)
            <div class="inline-flex items-center space-x-2">
                <div>@lang($name)</div>
                {{ $slot }}

                @if($withOrdering)
                    <x-ark-icon name="{{ $this->renderDirectionIcon($name) }}" size="xs" class="ml-2 w-2 h-2" />
                @endif
            </div>
        @else
            <div class="flex flex-row items-center">
                @lang($name)

                @if($withOrdering)
                    <x-ark-icon name="{{ $this->renderDirectionIcon($name) }}" size="xs" class="ml-2 w-2 h-2" />
                @endif
            </div>
        @endisset
    </th>
@endisset
