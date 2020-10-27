<?php

declare(strict_types=1);

use App\Http\Livewire\MonitorDelegateTable;
use Livewire\Livewire;

use function Tests\configureExplorerDatabase;

beforeEach(fn () => configureExplorerDatabase());

it('should render without errors', function () {
    $component = Livewire::test(MonitorDelegateTable::class);
});
