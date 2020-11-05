<div
    class="relative w-full"
    x-data="{
        options: {{ json_encode($options) }},
        onInput($dispatch) {
            @isset($dispatchEvent)
            $dispatch('{{$dispatchEvent}}', this.value)
            @endisset
        },
        init: function() {
            var e = this;
            this.$nextTick(() => {
                this.optionsCount = this.$refs.listbox.children.length;
            });
        },
        optionsCount: null,
        open: false,
        selected: 1,
        value: null,
        choose: function(value) {
            this.value = value;
            this.open = false;

            const { input } = this.$refs;
            input.value = value

            const event = new Event('input', {
                bubbles: true,
                cancelable: true,
            });

            input.dispatchEvent(event);
        },
        onButtonClick: function() {
            const { listbox } = this.$refs;
            const selectedIndex = Object.keys(this.options).indexOf(this.value);
            this.selected = selectedIndex >= 0 ? selectedIndex : 0;
            this.open = true;
            this.$nextTick(() => {
                listbox.focus();
                listbox.children[this.selected].scrollIntoView({
                    block: 'nearest'
                });
            })
        },
        onOptionSelect: function() {
            if (null !== this.selected) {
                this.choose(Object.keys(this.options)[this.selected])
            }
            this.open = false;
            this.$refs.button.focus();
        },
        onEscape: function() {
            this.open = false;
            this.$refs.button.focus();
        },
        onArrowUp: function() {
            const { listbox } = this.$refs;
            this.selected = this.selected - 1 < 0 ? this.optionsCount - 1 : this.selected - 1;
            console.log(this.selected, this.optionsCount )
            listbox.children[this.selected].scrollIntoView({
                block: 'nearest'
            });
        },
        onArrowDown: function() {
            const { listbox } = this.$refs;
            this.selected = this.selected + 1 > this.optionsCount - 1 ? 1 : this.selected + 1;
            console.log(this.selected)
            listbox.children[this.selected].scrollIntoView({
                block: 'nearest'
            });
        },
    }"
    x-init="init()"
>
    <input x-ref="input" {{ $attributes }} type="hidden" @input="onInput($dispatch)" />

    <button
        x-ref="button"
        @keydown.arrow-up.stop.prevent="onButtonClick()"
        @keydown.arrow-down.stop.prevent="onButtonClick()"
        @click="onButtonClick()"
        type="button"
        aria-haspopup="listbox"
        :aria-expanded="open"
        aria-labelledby="listbox-label"
        class="inline-block w-full px-4 py-3 text-left form-select transition-default"
    >
        <span x-show="options[value]" x-text="options[value]" class="block truncate"></span>
        <span x-show="!options[value]" class="block truncate">@if(isset($placeholder) && $placeholder) {{ $placeholder }} @else &nbsp; @endif</span>
    </button>

    <div
        x-show="open"
        @click.away="open = false"
        x-description="Select popover, show/hide based on select state."
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="absolute w-full mt-1"
        style="display: none;"
    >
        <ul
            @keydown.enter.stop.prevent="onOptionSelect()"
            @keydown.space.stop.prevent="onOptionSelect()"
            @keydown.escape="onEscape()"
            @keydown.arrow-up.prevent="onArrowUp()"
            @keydown.arrow-down.prevent="onArrowDown()"
            x-ref="listbox"
            tabindex="-1"
            role="listbox"
            aria-labelledby="listbox-label"
            class="py-3 overflow-auto bg-white rounded-md shadow-xs outline-none dark:bg-theme-secondary-800 dark:text-theme-secondary-200 hover:outline-none max-h-80"
        >
            <template x-for="(optionValue, index) in Object.keys(options)" :key="optionValue">
                <li
                    x-description="Select option, manage highlight styles based on mouseenter/mouseleave and keyboard navigation."
                    x-state:on="Highlighted"
                    x-state:off="Not Highlighted"
                    :id="`listbox-option-${optionValue}`"
                    role="option"
                    @click="choose(optionValue)"
                    @mouseenter="selected = index"
                    @mouseleave="selected = null"
                    :class="{ 'dropdown-entry-selected': value === optionValue }"
                    class="py-1 cursor-pointer dropdown-entry"
                    x-text="options[optionValue]"
                ></li>
            </template>
        </ul>
    </div>
</div>
