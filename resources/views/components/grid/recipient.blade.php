<x-details.address
    :title="trans('general.transaction.recipient')"
    :transaction="$transaction"
    :model="$model->recipient()"
    icon="app-volume" />
