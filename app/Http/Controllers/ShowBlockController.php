<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Block;
use Illuminate\View\View;

final class ShowBlockController
{
    public function __invoke(Block $block): View
    {
        return view('app.block', ['block' => $block]);
    }
}
