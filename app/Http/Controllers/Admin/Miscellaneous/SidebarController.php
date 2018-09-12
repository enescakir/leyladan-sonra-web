<?php

namespace App\Http\Controllers\Admin\Miscellaneous;

use App\CacheManagers\PostCacheManager;
use App\CacheManagers\UserCacheManager;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;

class SidebarController extends AdminController
{

    public function data(Request $request)
    {
        $data = [
            'unapproved-user-count' => UserCacheManager::count(['faculty_id' => auth()->user()->faculty_id, 'approval' => 0]),
            'unapproved-post-count' => PostCacheManager::count(['faculty_id' => auth()->user()->faculty_id, 'approval' => 0]),
        ];
        return api_success($data);
    }
}