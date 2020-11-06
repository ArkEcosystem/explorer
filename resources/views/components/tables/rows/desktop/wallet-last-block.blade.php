@if($model->justMissed())
    <span>@lang('generic.not-available')</span>
@elseif($model->isPending())
    <span>@lang('generic.to-be-done')</span>
@elseif($model->lastBlock())
    <a href="{{ route('block', $model->lastBlock()['id']) }}" class="font-semibold link">
        <x-truncate-middle :value="$model->lastBlock()['id']" />
    </a>
@endif
