<div>
    @lang('labels.productivity')

    <span>
        @if($model->productivity() >= 0)
        <x-percentage>
            {{ $model->productivity() }}
        </x-percentage>
        @else
            N/A
        @endif
    </span>
</div>
