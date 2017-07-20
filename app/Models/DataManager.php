<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Cache, DB;
use App\Models\Child, App\Models\Blood, App\Models\Volunteer,
    App\Models\User, App\Models\Faculty, App\Models\Feed;

class DataManager extends Model
{
    public static function childCount($faculty_id = null, $gift_state = null)
    {
      if ($faculty_id) {
        if ($gift_state) {
          return Cache::remember('child-count-' . $faculty_id . '-' . $gift_state, 15, function() use($faculty_id, $gift_state) {
              return Child::where('faculty_id', $faculty_id)->gift($gift_state)->count();
          });
        }
        return Cache::remember('child-count-' . $faculty_id, 15, function() use($faculty_id) {
            return Child::where('faculty_id', $faculty_id)->count();
        });
      }
      if ($gift_state) {
        return Cache::remember('child-count-' . $gift_state, 15, function() use($gift_state) {
            return Child::gift($gift_state)->count();
        });
      }
      return Cache::remember('child-count', 15, function() {
          return Child::count();
      });
    }

    public static function bloodCount()
    {
      return Cache::remember('blood-count', 15, function() {
          return Blood::count();
      });
    }

    public static function volunteerCount()
    {
      return Cache::remember('volunteer-count', 15, function() {
          return Volunteer::count();
      });
    }

    public static function userCount()
    {
      return Cache::remember('user-count', 15, function() {
          return User::count();
      });
    }

    public static function facultyCount($status = 'started')
    {
      switch ($status) {
        case "all":
          return Cache::remember('faculty-count', 15, function() {
              return Faculty::count();
          });
          break;
        case "not-started":
          return Cache::remember('faculty-count-notstarted', 15, function() {
              return Faculty::count() - Faculty::started()->count();
          });
          break;
        default:
          return Cache::remember('faculty-count-started', 15, function() {
              return Faculty::started()->count();
          });
      }
    }

    public static function cityCount()
    {
      return Cache::remember('city-count', 15, function() {
          return Faculty::started()->groupBy('code')->get()->count();
      });
    }

    public static function feeds($faculty_id = null, $limit = 15)
    {
      if ($faculty_id) {
        return Cache::remember('feed-' . $faculty_id, 5, function() use ($faculty_id, $limit) {
            return Feed::where('faculty_id', $faculty_id)->orderby('id', 'desc')->limit($limit)->get();
        });
      }
      return Cache::remember('feed', 5, function() use ($limit) {
          return Feed::orderby('id', 'desc')->limit($limit)->get();
      });
    }

    public static function childCountMonthly($faculty_id = null, $limit = 10)
    {
      $faculties = [];
      if ($faculty_id) {
        $faculties = Cache::remember('child-count-monthly-' . $faculty_id, 15, function() use ($faculty_id, $limit) {
          $facultiesRaw = DB::select('SELECT COUNT(*) as faculty, CONCAT(YEAR(meeting_day), "-", MONTH(meeting_day)) as month FROM children WHERE faculty_id = ' . $faculty_id . ' GROUP BY month ORDER BY meeting_day DESC LIMIT ' . $limit . ';');
          foreach($facultiesRaw as $value) { $faculties[$value->month] = ['faculty' => $value->faculty];}
          return $faculties;
        });
      }
      $general = Cache::remember('child-count-monthly', 15, function() use ($limit) {
        $generalRaw = DB::select('SELECT COUNT(*) as general, CONCAT(YEAR(meeting_day), "-", MONTH(meeting_day)) as month FROM children GROUP BY month ORDER BY meeting_day DESC LIMIT ' . $limit . ';');
        foreach($generalRaw as $value) { $general[$value->month] = ['general' => $value->general];}
        return $general;
      });
      if ($faculties) {
        return array_slice ( array_merge_recursive($general, $faculties), 0, $limit, true);
      } else {
        return $general;
      }
    }
}
