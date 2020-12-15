<?php

declare(strict_types=1);

use App\Models\Block;
use App\Models\Round;
use App\Models\Wallet;
use Tests\InvalidModel;
use App\Models\Transaction;
use App\ViewModels\BlockViewModel;
use App\ViewModels\RoundViewModel;
use Illuminate\Support\Collection;
use App\ViewModels\WalletViewModel;

use App\ViewModels\ViewModelFactory;
use App\ViewModels\TransactionViewModel;
use function Tests\configureExplorerDatabase;

it('should make a view model', function ($modelClass, $viewModel) {
    configureExplorerDatabase();

    expect(ViewModelFactory::make($modelClass::factory()->create()))->toBeInstanceOf($viewModel);
})->with([
    [Block::class, BlockViewModel::class],
    [Round::class, RoundViewModel::class],
    [Transaction::class, TransactionViewModel::class],
    [Wallet::class, WalletViewModel::class],
]);

it('should make a view model collection', function ($modelClass, $viewModel) {
    configureExplorerDatabase();

    $models = $modelClass::factory(10)->create();

    expect(ViewModelFactory::collection($models))->toBeInstanceOf(Collection::class);

    foreach ($models as $model) {
        expect($model)->toBeInstanceOf($viewModel);
    }
})->with([
    [Block::class, BlockViewModel::class],
    [Round::class, RoundViewModel::class],
    [Transaction::class, TransactionViewModel::class],
    [Wallet::class, WalletViewModel::class],
]);

it('cannot make an invalid view model', function () {
    $this->expectException(InvalidArgumentException::class);

    ViewModelFactory::make(new InvalidModel());
})->throws(InvalidArgumentException::class);
