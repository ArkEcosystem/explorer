@php($withOrdering = $attributes->get('with-ordering'))

@isset($responsive)
    <th
        class="hidden {{ $breakpoint ?? 'lg'}}:table-cell text-right @if($withOrdering) cursor-pointer @endif"
        {{ $attributes->except(['class', 'breakpoint', 'responsive']) }}
    >
        <div class="flex flex-row items-center relative">
            @lang($name)

            @if($withOrdering)
                <x-ark-icon name="{{ $this->renderDirectionIcon($name) }}" size="xs" class="ml-14 w-2 h-2 sorting absolute" />
            @endif
        </div>
    </th>
@else
    <th
        class="text-right @if($withOrdering) cursor-pointer @endif"
        {{ $attributes->except(['class', 'breakpoint', 'responsive']) }}
    >
        @isset ($slot)
            <div class="inline-flex items-center space-x-5 relative">
                @if($withOrdering)
                    <x-ark-icon name="{{ $this->renderDirectionIcon($name) }}" size="xs" class="w-2 h-2 sorting absolute" />
                @endif

                <div>@lang($name)</div>

                {{ $slot }}
            </div>
        @else
            <div class="flex flex-row items-center">
                @lang($name)

                @if($withOrdering)
                    <x-ark-icon name="{{ $this->renderDirectionIcon($name) }}" size="xs" class="ml-2 w-2 h-2 sorting" />
                @endif
            </div>
        @endisset
    </th>
@endisset
