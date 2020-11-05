<?php

namespace App\View\Components;

use Illuminate\View\Component;

class RichSelect extends Component
{
    public string $placeholder = '';

    public array $options;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(array $options, string $placeholder = '')
    {
        $this->options = $options;
        $this->placeholder = $placeholder;
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
