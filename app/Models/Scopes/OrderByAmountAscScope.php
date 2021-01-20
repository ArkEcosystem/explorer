<?php

declare(strict_types=1);

namespace App\Models\Scopes;

use App\Models\Concerns\QueryWithCalculatedAmount;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

final class OrderByAmountAscScope implements Scope
{
    use QueryWithCalculatedAmount;

    public function apply(Builder $builder, Model $model)
    {
        $this->baseCalculatedAmountQuery($builder, 'asc');
    }
}
