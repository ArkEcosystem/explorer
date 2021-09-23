@if($shortened ?? false)
    <x-time
        :datetime="$model->datetime()"
        :format="DateFormat::TIME_SHORT_JS"
    />
@else
    <x-time
        :datetime="$model->datetime()"
        :format="DateFormat::TIME_JS"
    />
@endif
