<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class StaticController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function children_by_general()
    {
        $result = DB::select("SELECT COUNT(*) as count, YEAR(meeting_day) as year, MONTHNAME(meeting_day) as month FROM children GROUP BY year, MONTH(meeting_day) ORDER BY year DESC, MONTH(meeting_day) DESC LIMIT 10;");

        $childrenCount = [];
        foreach ($result as $key => $value) {
            array_push($childrenCount, array( substr($value->month,0,3) , $value->count ));
        }
        return array_reverse($childrenCount);
    }

    public function children_by_faculty($id)
    {
        $result = DB::select("SELECT COUNT(*) as count, YEAR(meeting_day) as year, MONTHNAME(meeting_day) as month FROM children WHERE faculty_id = ". $id ." GROUP BY year, MONTH(meeting_day) ORDER BY year DESC, MONTH(meeting_day) DESC LIMIT 10;");

        $childrenCount = [];
        foreach ($result as $key => $value) {
            array_push($childrenCount, array( substr($value->month,0,3) , $value->count ));
        }
        return array_reverse($childrenCount);
    }

}
