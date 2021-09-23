@props(['datetime', 'format'])

<span
    x-data="{
        timestamp: {{ $datetime->timestamp }},
        format: '{{ $format }}',
        output: '',
    }"
    x-init="() => {
        output = dayjs(timestamp * 1000).format(format);
        console.log('dayjs', timestamp, format, dayjs(timestamp), '{{ $datetime }}');
    }"
    x-text="output"
></span>
