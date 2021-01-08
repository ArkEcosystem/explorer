<?php

declare(strict_types=1);

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

final class OrderByVoteScope extends BaseOrderByScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        // TODO: Ordering not fully functional, e.g, these 3 numbers would be outputted in that sequence ; 570, 4, 47.461, which is incorrect
        $builder->orderByRaw("(\"attributes\"->'delegate'->>'voteBalance')::numeric ".strtoupper($this->direction));
    }
}
