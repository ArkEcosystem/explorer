<div>
    @lang('labels.last_block')

    <div wire:loading.class="w-full h-5 rounded-full bg-theme-secondary-300 animate-pulse"></div>
    <div wire:loading.class="hidden">{{ $model->lastBlock() }}</div>
</div>
