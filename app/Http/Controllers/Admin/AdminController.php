<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function paginate(Builder $query)
    {
        $currentPage = request('page');
        $result = $query->paginate();
        if ($currentPage && $currentPage != 1 && $currentPage > $result->lastPage()) {
            abort(redirect(request()->fullUrlWithQuery(array_merge(request()->all(),
                ['page' => $result->lastPage()]))));
        }
        return $result;
    }
}