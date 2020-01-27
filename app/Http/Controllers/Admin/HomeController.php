<?php

namespace App\Http\Controllers\Admin;

use App\Filters\FacultyFilter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faculty;
use App\Models\User;

class HomeController extends Controller
{

    public function index()
    {
        return redirect()->route('admin.login');
    }
}