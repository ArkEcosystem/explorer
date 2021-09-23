<div>
    @lang('labels.timestamp')

    <div>
        <x-ark-local-time
            :datetime="$model->datetime()"
            :format="DateFormat::TIME_JS"
            :placeholder="$model->timestamp()"
        />
    </div>
</div>
