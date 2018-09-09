<?php

namespace App\Services;

use App\CacheManagers\FacultyCacheManager;
use App\Models\Faculty;
use App\CacheManagers\CacheManager;
use App\CacheManagers\ChildCacheManager;
use App\CacheManagers\CityCacheManager;
use App\CacheManagers\UserCacheManager;

class DashboardService extends Service
{
    protected $childCache;
    protected $userCache;
    protected $cityCache;

    public function __construct()
    {
    }


    public function counts()
    {
        return CacheManager::counts();
    }

    public function facultyCounts()
    {
        return FacultyCacheManager::counts();
    }

    public function childCountByGift($faculty_id)
    {
        return [
            'general' => ChildCacheManager::countByGift(),
            'faculty' => ChildCacheManager::countByGift($faculty_id)
        ];
    }

    public function childCountMonthly($faculty_id)
    {
        return [
            'faculty' => Faculty::find($faculty_id)->full_name ?? null,
            'counts'  => ChildCacheManager::monthlyCount([
                'faculty_id' => $faculty_id,
                'monthCount' => 12
            ])
        ];
    }

    public function birthdays($faculty_id)
    {
        $users = UserCacheManager::birthdays($faculty_id);
        $children = ChildCacheManager::birthdays($faculty_id);
        return $users->merge($children);
    }

    public function cityColors()
    {
        return CityCacheManager::colors();
    }

    public function cityFaculties($cityCode)
    {
        return CityCacheManager::faculties($cityCode);
    }

    public function getData($type, $parameter)
    {
        $name = camel_case($type);
        if (method_exists($this, $name)){
            return $this->$name($parameter);
        }
        return null;
    }
}