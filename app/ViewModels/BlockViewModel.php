<?php

declare(strict_types=1);

namespace App\ViewModels;

use App\Facades\Network;
use App\Models\Block;
use App\Services\NumberFormatter;
use App\Services\Timestamp;
use ARKEcosystem\UserInterface\Support\DateFormat;
use Spatie\ViewModels\ViewModel;

final class BlockViewModel extends ViewModel
{
    private Block $model;

    public function __construct(Block $block)
    {
        $this->model = $block;
    }

    public function url(): string
    {
        return route('block', $this->model->id);
    }

    public function id(): string
    {
        return $this->model->id;
    }

    public function timestamp(): string
    {
        return Timestamp::fromGenesisHuman($this->model->timestamp);
    }

    public function delegate(): string
    {
        $delegate = $this->model->delegate;

        if (is_null($delegate)) {
            return 'n/a';
        }

        return $delegate->username;
    }

    public function height(): string
    {
        return NumberFormatter::number($this->model->height);
    }

    public function transactionCount(): int
    {
        return $this->model->number_of_transactions;
    }

    public function amount(): string
    {
        return NumberFormatter::currency($this->model->total_amount / 1e8, Network::currency());
    }

    public function fee(): string
    {
        return NumberFormatter::currency($this->model->total_fee / 1e8, Network::currency());
    }

    public function reward(): string
    {
        return NumberFormatter::currency($this->model->reward / 1e8, Network::currency());
    }
}
