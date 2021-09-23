<div>
    @lang('labels.timestamp')

    <div>
        <x-time
            :datetime="$model->datetime()"
            :format="DateFormat::TIME_JS"
        />
    </div>
</div>
