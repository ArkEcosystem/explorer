<?php

declare(strict_types=1);

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

final class OrderByIdScope implements Scope
{
    protected array $parameters;

    public function __construct(array ...$parameters)
    {
        $this->parameters = $parameters;
    }

    public function apply(Builder $builder, Model $model)
    {
        $builder->orderBy('id', ...$this->parameters);
    }
}
