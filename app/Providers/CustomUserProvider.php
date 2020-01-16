<?php

namespace App\Providers;

use Illuminate\Auth\EloquentUserProvider;

class CustomUserProvider extends EloquentUserProvider
{
    protected function newModelQuery($model = null)
    {

        return parent::newModelQuery($model)->withGraduateds();
    }
}