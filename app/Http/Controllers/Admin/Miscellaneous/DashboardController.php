<?php

namespace App\Http\Controllers\Admin\Miscellaneous;

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use App\Services\DashboardService;

class DashboardController extends AdminController
{

    protected $service;

    public function __construct(DashboardService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $childCounts = $this->service->childCountByGift(auth()->user()->faculty_id);
        $generalCounts = $this->service->counts();
        $facultyCounts = $this->service->facultyCounts();

        return view('admin.dashboard', compact('childCounts', 'generalCounts', 'facultyCounts'));
    }

    public function data(Request $request)
    {
        $data = $this->service->getData($request->type, $request->parameter);

        return api_success($data);
    }

    public function blank()
    {
        return view('admin.blank');
    }
}