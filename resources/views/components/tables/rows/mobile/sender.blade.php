<div>
    @lang('labels.sender')

    <x-general.address :address="$model->sender()->address()" :username="$model->sender()->username()" with-loading />
</div>
