<x-details.address
    :title="trans('general.transaction.sender')"
    :transaction="$transaction"
    :model="$model->sender()"
    icon="app-volume" />
