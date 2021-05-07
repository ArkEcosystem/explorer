@php($withOrdering = $attributes->get('with-ordering'))

@isset($responsive)
    <th
        class="hidden {{ $breakpoint ?? 'lg' }}:table-cell text-left @if($withOrdering) cursor-pointer @endif"
        {{ $attributes->except(['class', 'breakpoint', 'responsive']) }}
    >
        <div class="flex flex-row items-center">
            @lang($name)

            @if($withOrdering)
                <x-ark-icon name="{{ $this->renderDirectionIcon($name) }}" size="xs" class="ml-2 w-2 h-2 sorting" />
            @endif
        </div>
    </th>
@else
    <th
        class="text-left @if($withOrdering) cursor-pointer @endif"
        {{ $attributes->except(['class', 'breakpoint', 'responsive']) }}
    >
        <div class="flex flex-row items-center relative">
            @lang($name)

            @if($withOrdering)
                <x-ark-icon name="{{ $this->renderDirectionIcon($name) }}" size="xs" class="ml-10 w-2 h-2 sorting absolute" />
            @endif
        </div>
    </th>
@endisset
