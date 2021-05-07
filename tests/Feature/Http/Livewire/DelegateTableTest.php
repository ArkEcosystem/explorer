<?php

declare(strict_types=1);

use App\Enums\OrderingDirectionEnum;
use App\Enums\OrderingTypeEnum;
use App\Http\Livewire\DelegateTable;
use Livewire\Livewire;

use function Tests\configureExplorerDatabase;

beforeEach(fn () => configureExplorerDatabase());

// @TODO: make assertions about data visibility
it('should render with all delegates', function () {
    $component = Livewire::test(DelegateTable::class);
    $component->emit('filterByDelegateStatus', 'all');
});

// @TODO: make assertions about data visibility
it('should render with standby delegates', function () {
    $component = Livewire::test(DelegateTable::class);
    $component->emit('filterByDelegateStatus', 'standby');
});

// @TODO: make assertions about data visibility
it('should render with resigned delegates', function () {
    $component = Livewire::test(DelegateTable::class);
    $component->emit('filterByDelegateStatus', 'resigned');
});

it('should apply ordering through an event', function () {
    $component = Livewire::test(DelegateTable::class);

    $component->assertSet('ordering', OrderingTypeEnum::RANK);
    $component->assertSet('orderingDirection', OrderingDirectionEnum::ASC);

    $component->emit('orderDelegatesBy', OrderingTypeEnum::RANK);

    $component->assertSet('ordering', OrderingTypeEnum::RANK);
    $component->assertSet('orderingDirection', OrderingDirectionEnum::DESC);

    $component->emit('orderDelegatesBy', OrderingTypeEnum::ADDRESS);

    $component->assertSet('ordering', OrderingTypeEnum::ADDRESS);
    $component->assertSet('orderingDirection', OrderingDirectionEnum::ASC);
});
