@if($model->justMissed())
    <span>@lang('generic.n-a')</span>
@elseif(! $model->isDone())
    <span>@lang('generic.tbd')</span>
@elseif($model->lastBlock())
    <a href="{{ route('block', $model->lastBlock()['id']) }}" class="font-semibold link">
        <x-truncate-middle :value="$model->lastBlock()['id']" />
    </a>
@endif
