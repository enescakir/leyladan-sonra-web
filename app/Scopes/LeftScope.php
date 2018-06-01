<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class LeftScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->whereNull('left_at');
    }

    /**
     * Extend the query builder with the needed functions.
     *
     * @param Builder $builder
     */
    public function extend(Builder $builder)
    {
        $builder->macro('withLefts', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });
    }
}
