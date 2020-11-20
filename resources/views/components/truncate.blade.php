<span
    x-data="{
        value: '{{ $slot }}',
        truncated: '{{ $slot }}',
        truncate() {
            const el = this.$el;

            el.innerHTML = ''
            el.appendChild(document.createTextNode(this.value));

            if (!this.hasOverflow(el)) {
                return;
            }

            let length = this.value.length;
            do {
                const a = this.value.substr(0, length);
                const b = this.value.substr(-length);
                const truncated = a + '...' + b;

                el.innerHTML = ''
                el.appendChild(document.createTextNode(truncated));

                length--;
            } while(this.hasOverflow(el))

        },
        hasOverflow(el) {
            return el.offsetWidth < el.scrollWidth;
        },
    }"
    x-init="truncate"
    x-on:resize.window="truncate"
    class="inline-block w-full max-w-full overflow-hidden whitespace-no-wrap"
    x-text="truncated"
>{{ $slot }}</span>
