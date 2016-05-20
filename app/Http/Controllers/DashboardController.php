<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth, DB, Mail, App\User;

class DashboardController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $user = Auth::user();
        $totalChild = DB::table('children')->count();
        $totalBlood = DB::table('bloods')->count();
        $totalVolunteer = DB::table('volunteers')->count();
        $totalUser = DB::table('users')->count();
        $waitGeneralChild = DB::table('children')->where('gift_state','Bekleniyor')->count();
        $roadGeneralChild = DB::table('children')->where('gift_state','Yolda')->count();
        $reachGeneralChild = DB::table('children')->where('gift_state','Bize Ulaştı')->count();
        $deliveredGeneralChild = DB::table('children')->where('gift_state','Teslim Edildi')->count();
        $waitFacultyChild = DB::table('children')->where('faculty_id', $user->faculty_id)->where('gift_state','Bekleniyor')->count();
        $roadFacultyChild = DB::table('children')->where('faculty_id', $user->faculty_id)->where('gift_state','Yolda')->count();
        $reachFacultyChild = DB::table('children')->where('faculty_id', $user->faculty_id)->where('gift_state','Bize Ulaştı')->count();
        $deliveredFacultyChild = DB::table('children')->where('faculty_id', $user->faculty_id)->where('gift_state','Teslim Edildi')->count();
        return view('admin.dashboard', compact(['totalChild', 'totalBlood', 'totalVolunteer', 'totalUser', 'waitGeneralChild', 'roadGeneralChild', 'reachGeneralChild', 'deliveredGeneralChild', 'waitFacultyChild', 'roadFacultyChild', 'reachFacultyChild', 'deliveredFacultyChild']));
    }

    public function birthdays()
    {
        $user = Auth::user();
        $birthdays = [];
        $users = DB::select("SELECT first_name,last_name,birthday,faculty_id FROM users WHERE faculty_id = ". $user->faculty_id . " AND MONTH(birthday) = ". date("n") );
        $children = DB::select("SELECT first_name,last_name,birthday,faculty_id FROM children WHERE faculty_id = ". $user->faculty_id . " AND MONTH(birthday) = ". date("n"));

        foreach ($users as $key => $value) {
            $object = new \stdClass();
            $object->title = $value->first_name . " " . $value->last_name;
            $object->start = date("Y") . substr($value->birthday,4);
            $object->backgroundColor = "#F3565D";
            array_push($birthdays, $object);
        }

        foreach ($children as $key => $value) {
            $object = new \stdClass();
            $object->title = $value->first_name . " " . $value->last_name;
            $object->start = date("Y") . substr($value->birthday,4);
            $object->backgroundColor = "#1bbc9b";
            array_push($birthdays, $object);
        }

        return $birthdays;
    }

    /**
     * Show the blank page.
     *
     * @return \Illuminate\Http\Response
     */
    public function blank()
    {
        return view('admin.blank');
    }

    public function materials()
    {
        return view('admin.materials');
    }

    public function manual(){
        return 'Çok yakında sizlerle';
    }

    public function sendEmail()
    {
        $user = User::find(1);
//        Mail::send('email.admin.activation', ['user' => $user], function ($m) use ($user) {
//            $m->to($user->email)->subject('Hesabınız artık aktif!');
//        });
        return 'Success';
    }

    public function moving()
    {
        $faculties = DB::table('faculties')->get();
        $numbers = [];
        $olds =
            [
                'istanbultip' => 308,
                'cukurova' => 216,
                'erciyes' => 259,
                'akdeniz' => 135,
                'kocaeli' => 144,
                'bulentecevit' => 33,
                'yildirimbeyazit' => 72,
                'gazi' => 166,
                'cerrahpasa' => 112,
                'meram' => 104,
                'ege' => 19,
                'turgutozal' => 19,
                'suleymandemirel' => 31,
                'medipol' => 2,
                'osmangazi' => 64,
                'cumhuriyet' => 8,
                'medeniyet' => 17,
                'gaziantep' => 47,
                'inonu' => 36,
                'karadenizteknik' => 57,
                'selcuk' => 33,
                'celalbayar' => 16,
                'abant' => 7,
                'karatay' => 18,
                'gaziosmanpasa' => 48,
                'ondokuzmayis' => 15,
                'ordu' => 1,
                'yuzuncuyil' => 26,
                'ataturk' => 12,
                'sakarya' => 5,
                'katipcelebi' => 40,
                'dicle' => 7,
                'sutcuimam' => 4,
                'afyonkocatepe' => 0,
            ];

        foreach($faculties as $key => $faculty){
            $object = new \stdClass();
            $object->name = $faculty->full_name . " Tıp Fakültesi";
            $object->new = DB::table('children')->where('faculty_id', $faculty->id)->count();
            $object->newSystem = DB::table('children')->select(DB::raw('count(*) as count, gift_state'))->where('faculty_id', $faculty->id)->groupby('gift_state')->get();
            $object->old =  $olds[$faculty->slug];
            if($faculty->slug == "istanbultip"){
                $object->new = $object->new + 150;
            }
            array_push($numbers, $object);
        }
        return view('admin.moving', compact('numbers'));
    }



}
