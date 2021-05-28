<x-general.identity :model="$model" :without-truncate="$withoutTruncate ?? false">
    <x-slot name="suffix">
        @if ($model->username())
            <span style="max-width: 125px" class="hidden max-w-xs ml-1 overflow-auto lg:flex">
                <x-truncate-dynamic>{{ $model->address() }}</x-truncate-dynamic>
            </span>
        @endif
    </x-slot>
</x-general.identity>
