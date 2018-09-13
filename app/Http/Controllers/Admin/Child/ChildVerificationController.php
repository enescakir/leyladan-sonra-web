<?php

namespace App\Http\Controllers\Admin\Child;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Child;

class ChildVerificationController extends AdminController
{

    public function show(Child $child)
    {
        $path = $child->getFirstMediaPath('verification');

        return response()->file($path);
    }
}
