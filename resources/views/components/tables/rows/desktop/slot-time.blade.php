@if ($model->isNext())
    @lang('pages.monitor.now')
@elseif ($model->forgingAt()->isPast())
    @lang('pages.monitor.completed')
@else
    {{ $model->forgingAt()->diffForHumans() }}
@endif
