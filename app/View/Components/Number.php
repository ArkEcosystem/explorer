<?php

declare(strict_types=1);

namespace App\View\Components;

use Illuminate\View\Component;

final class Number extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return <<<'blade'
<div>
    <!-- It is quality rather than quantity that matters. - Lucius Annaeus Seneca -->
</div>
blade;
    }
}
