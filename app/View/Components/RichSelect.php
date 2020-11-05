<?php

namespace App\View\Components;

use Illuminate\View\Component;

class RichSelect extends Component
{
    public string $placeholder = '';

    public array $options;

    public ?string $initialValue;

    public ?string $dispatchEvent;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(array $options, ?string $initialValue = null, string $placeholder = '', ?string $dispatchEvent = null)
    {
        $this->options = $options;
        $this->initialValue = $initialValue;
        $this->placeholder = $placeholder;
        $this->dispatchEvent = $dispatchEvent;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.rich-select');
    }
}
