<div>
    @lang('labels.recipient')

    <x-general.address
        :address="$model->recipient()->address()"
        :username="$model->recipient()->username()"
        with-loading
    />
</div>
