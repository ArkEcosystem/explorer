@if($model->productivity() >= 0)
<x-percentage>
    {{ $model->productivity() }}
</x-percentage>
@else
    N/A
@endif