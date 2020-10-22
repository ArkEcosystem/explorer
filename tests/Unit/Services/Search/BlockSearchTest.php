<?php

declare(strict_types=1);

use App\Models\Block;
use App\Services\Search\BlockSearch;

use function Tests\configureExplorerDatabase;

beforeEach(fn () => configureExplorerDatabase());

it('should search for a block by id', function () {
    $block = Block::factory(10)->create()[0];

    $result = (new BlockSearch())->search([
        'term' => $block->id,
    ]);

    expect($result->get())->toHaveCount(1);
});
