<?php

declare(strict_types=1);

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

final class OrderByConfirmationDescScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->orderBy('block_height', 'desc');
    }
}
