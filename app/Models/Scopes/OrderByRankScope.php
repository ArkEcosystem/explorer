<?php

declare(strict_types=1);

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

final class OrderByRankScope implements Scope
{
    protected string $direction;

    public function __construct(string $direction = 'asc')
    {
        $this->direction = $direction;
    }

    public function apply(Builder $builder, Model $model)
    {
        $builder->orderByRaw("(\"attributes\"->'delegate'->>'rank')::numeric ".strtoupper($this->direction));
    }
}
