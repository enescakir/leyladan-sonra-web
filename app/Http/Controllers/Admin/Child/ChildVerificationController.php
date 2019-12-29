<?php

namespace App\Http\Controllers\Admin\Child;

use App\Http\Controllers\Controller;
use App\Models\Child;

class ChildVerificationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Child $child)
    {
        $path = $child->getFirstMediaPath('verification');

        return response()->file($path);
    }
}
