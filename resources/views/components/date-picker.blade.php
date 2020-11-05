<input
    x-data
    x-ref="input"
    x-init="new Pikaday({
        field: $refs.input,
        format: 'DD/MM/YYYY',
        maxDate: new Date(),
        toString(date, format) {
            return date.toLocaleDateString('en-US', { year: 'numeric', month: '2-digit', day: '2-digit' });
        },
    })"
    type="text"
    onchange="this.dispatchEvent(new InputEvent('input'))"
    {{ $attributes }}
>
