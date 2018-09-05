<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class GraduateScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->whereNull('graduated_at');
    }

    /**
     * Extend the query builder with the needed functions.
     *
     * @param Builder $builder
     */
    public function extend(Builder $builder)
    {
        $builder->macro('withGraduateds', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });
    }
}
