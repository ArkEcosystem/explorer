<?php

declare(strict_types=1);

namespace App\Http\Livewire\Concerns;

trait PerformsInitialLoad
{
    public bool $performedInitialLoad = false;

    public function performedInitialLoad(): void
    {
        $this->performedInitialLoad = true;
    }
}
