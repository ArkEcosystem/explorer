<?php

declare(strict_types=1);

use App\Http\Livewire\MonitorDelegateTabs;
use Livewire\Livewire;

use function Tests\configureExplorerDatabase;

beforeEach(fn () => configureExplorerDatabase());

it('should render without errors', function () {
    $component = Livewire::test(MonitorDelegateTabs::class);
});
