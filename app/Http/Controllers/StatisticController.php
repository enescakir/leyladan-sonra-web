<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth, DB, App\Child, App\User, LaravelAnalytics;

class StatisticController extends Controller
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

    public function user()
    {
        $user = Auth::user();
        $youngest = User::select('birthday')->orderby('birthday','desc')->first();
        $oldest = User::select('birthday')->orderby('birthday')->first();
        $ageAve = DB::select("SELECT AVG(TIMESTAMPDIFF(YEAR, birthday, CURDATE())) AS `average` FROM users;")[0];
        return view('admin.statistics.user', compact(['user', 'youngest', 'oldest', 'ageAve']));

    }

    public function userHoroscope(){
        $koc = DB::select("SELECT 'Koç' AS 'horoscope', count(*) AS 'number' FROM users WHERE (MONTH(birthday) = 3 AND DAY(birthday) >= 21) OR (MONTH(birthday) = 4 AND DAY(birthday) <= 19)")[0];
        $boga = DB::select("SELECT 'Boğa' AS 'horoscope', count(*) AS 'number' FROM users WHERE (MONTH(birthday) = 4 AND DAY(birthday) >= 20) OR (MONTH(birthday) = 5 AND DAY(birthday) <= 20)")[0];
        $ikizler = DB::select("SELECT 'İkizler' AS 'horoscope', count(*) AS 'number' FROM users WHERE (MONTH(birthday) = 5 AND DAY(birthday) >= 21) OR (MONTH(birthday) = 6 AND DAY(birthday) <= 21)")[0];
        $yengec = DB::select("SELECT 'Yengeç' AS 'horoscope', count(*) AS 'number' FROM users WHERE (MONTH(birthday) = 6 AND DAY(birthday) >= 22) OR (MONTH(birthday) = 7 AND DAY(birthday) <= 22)")[0];
        $aslan = DB::select("SELECT 'Aslan' AS 'horoscope', count(*) AS 'number' FROM users WHERE (MONTH(birthday) = 7 AND DAY(birthday) >= 23) OR (MONTH(birthday) = 8 AND DAY(birthday) <= 22)")[0];
        $basak = DB::select("SELECT 'Başak' AS 'horoscope', count(*) AS 'number' FROM users WHERE (MONTH(birthday) = 8 AND DAY(birthday) >= 23) OR (MONTH(birthday) = 9 AND DAY(birthday) <= 22)")[0];
        $terazi = DB::select("SELECT 'Terazi' AS 'horoscope', count(*) AS 'number' FROM users WHERE (MONTH(birthday) = 9 AND DAY(birthday) >= 23) OR (MONTH(birthday) = 10 AND DAY(birthday) <= 22)")[0];
        $akrep = DB::select("SELECT 'Akrep' AS 'horoscope', count(*) AS 'number' FROM users WHERE (MONTH(birthday) = 10 AND DAY(birthday) >= 23) OR (MONTH(birthday) = 11 AND DAY(birthday) <= 21)")[0];
        $yay = DB::select("SELECT 'Yay' AS 'horoscope', count(*) AS 'number' FROM users WHERE (MONTH(birthday) = 11 AND DAY(birthday) >= 22) OR (MONTH(birthday) = 12 AND DAY(birthday) <= 21)")[0];
        $oglak = DB::select("SELECT 'Oğlak' AS 'horoscope', count(*) AS 'number' FROM users WHERE (MONTH(birthday) = 12 AND DAY(birthday) >= 22) OR (MONTH(birthday) = 1 AND DAY(birthday) <= 19)")[0];
        $kova = DB::select("SELECT 'Kova' AS 'horoscope', count(*) AS 'number' FROM users WHERE (MONTH(birthday) = 1 AND DAY(birthday) >= 20) OR (MONTH(birthday) = 2 AND DAY(birthday) <= 18)")[0];
        $balik = DB::select("SELECT 'Balık' AS 'horoscope', count(*) AS 'number' FROM users WHERE (MONTH(birthday) = 2 AND DAY(birthday) >= 19) OR (MONTH(birthday) = 3 AND DAY(birthday) <= 20)")[0];
        $horoscope = array($koc, $boga, $ikizler, $yengec, $aslan, $basak, $terazi, $akrep, $yay, $oglak, $kova, $balik );
        return $horoscope;


    }

    public function website(){
        return view('admin.statistics.website');
    }

}
