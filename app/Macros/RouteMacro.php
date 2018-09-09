<?php

namespace App\Macros;

use Route as BaseRoute;

class RouteMacro
{
    public static function registerMacros()
    {
        if (!BaseRoute::hasMacro('approve')) {
            BaseRoute::macro('approve', function ($name, $controller) {
                BaseRoute::as("{$name}.approve")->put("{$name}/{{$name}}/approve", "{$controller}@approve");
            });
        }
    }
}