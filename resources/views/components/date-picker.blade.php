@push('scripts')
    <style>
        .pika-table td.is-disabled {
            background-color: #fcfdfd;
        }

        .pika-button .is-selected {
            background-color: #075af2;
        }

        .pika-button:hover {
            background-color: #007dff;
        }
    </style>
@endpush

<input
    x-data
    x-ref="input"
    x-init="new Pikaday({
        field: $refs.input,
        format: 'DD/MM/YYYY',
        minDate: new Date('{{ Network::epoch() }}'),
        maxDate: new Date(),
        toString(date, format) {
            return date.toLocaleDateString('en-US', { year: 'numeric', month: '2-digit', day: '2-digit' });
        },
    })"
    type="text"
    onchange="this.dispatchEvent(new InputEvent('input'))"
    {{ $attributes }}
>
