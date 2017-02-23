<?php

namespace App\Http\Controllers;

use App\Faculty;
use Illuminate\Http\Request;

use App\Http\Requests;
use Auth, DB, Mail, App\User, App\Child, App\Volunteer, App\Chat, App\Feed;
use Illuminate\Support\Facades\Log;
use PDF, Newsletter, PushNotification, Cache, Session;

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
        $user->used = count(DB::select('select * from oylar where used_by = ?', [$user->id])) > 0;

        $totalChild = Cache::remember('totalChildren', 15, function() {
            return DB::table('children')->count();
        });

        $totalBlood = Cache::remember('totalBlood', 15, function() {
            return DB::table('bloods')->count();
        });

        $totalVolunteer = Cache::remember('totalVolunteer', 15, function() {
            return DB::table('volunteers')->count();
        });

        $totalUser = Cache::remember('totalUser', 15, function() {
            return DB::table('users')->count();
        });

        $waitGeneralChild = Cache::remember('waitGeneralChild', 15, function() {
            return DB::table('children')->where('gift_state','Bekleniyor')->count();
        });

        $roadGeneralChild = Cache::remember('roadGeneralChild', 15, function() {
            return DB::table('children')->where('gift_state','Yolda')->count();
        });

        $reachGeneralChild = Cache::remember('reachGeneralChild', 15, function() {
            return DB::table('children')->where('gift_state','Bize Ulaştı')->count();
        });

        $deliveredGeneralChild = Cache::remember('deliveredGeneralChild', 15, function() {
            return DB::table('children')->where('gift_state','Teslim Edildi')->count();
        });

        $waitFacultyChild = Cache::remember('waitFacultyChild-' . $user->faculty_id, 15, function() use ($user) {
            return DB::table('children')->where('faculty_id', $user->faculty_id)->where('gift_state','Bekleniyor')->count();
        });

        $roadFacultyChild = Cache::remember('roadFacultyChild-' . $user->faculty_id, 15, function() use ($user) {
            return DB::table('children')->where('faculty_id', $user->faculty_id)->where('gift_state','Yolda')->count();
        });

        $reachFacultyChild = Cache::remember('reachFacultyChild-' . $user->faculty_id, 15, function() use ($user) {
            return DB::table('children')->where('faculty_id', $user->faculty_id)->where('gift_state','Bize Ulaştı')->count();
        });

        $deliveredFacultyChild = Cache::remember('deliveredFacultyChild-' . $user->faculty_id, 15, function() use ($user) {
            return DB::table('children')->where('faculty_id', $user->faculty_id)->where('gift_state','Teslim Edildi')->count();
        });

        $feeds = Cache::remember('faculty-feeds-' . $user->faculty_id, 5, function() use ($user) {
            return Feed::where('faculty_id', $user->faculty_id)->orderby('id', 'desc')->limit(30)->get();
        });

        return view('admin.dashboard', compact(['totalChild', 'totalBlood', 'totalVolunteer', 'totalUser',
            'waitGeneralChild', 'roadGeneralChild', 'reachGeneralChild', 'deliveredGeneralChild', 'waitFacultyChild',
            'roadFacultyChild', 'reachFacultyChild', 'deliveredFacultyChild', 'feeds']))->with(['authUser' => $user]);
    }

    public function birthdays()
    {

        $user = Auth::user();
        $birthdays = Cache::remember('birthdays-' . $user->faculty_id, 60, function() use ($user) {
            $birthdays2 = [];
            $users = DB::select("SELECT first_name,last_name,birthday,faculty_id FROM users WHERE faculty_id = ". $user->faculty_id . " AND MONTH(birthday) = ". date("n") );
            $children = DB::select("SELECT first_name,last_name,birthday,faculty_id FROM children WHERE faculty_id = ". $user->faculty_id . " AND MONTH(birthday) = ". date("n"));

            foreach ($users as $key => $value) {
                $object = new \stdClass();
                $object->title = $value->first_name . " " . $value->last_name;
                $object->start = date("Y") . substr($value->birthday,4);
                $object->backgroundColor = "#F3565D";
                array_push($birthdays2, $object);
            }

            foreach ($children as $key => $value) {
                $object = new \stdClass();
                $object->title = $value->first_name . " " . $value->last_name;
                $object->start = date("Y") . substr($value->birthday,4);
                $object->backgroundColor = "#1bbc9b";
                array_push($birthdays2, $object);
            }
            return $birthdays2;
        });

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
        return view('admin.manual');
    }

    public function createForm()
    {
        return view('admin.createForm');
    }

    public function storeForm(Request $request){

        $text = $request->text;
        $form = '
            <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
            <html lang="tr">
            <head>
            	<meta http-equiv="content-type" content="text/html; charset=utf-8">
            	<title>Onay Formu</title>
            	<style>
                    @font-face { font-family: MinionProRegular; src: url(resources/admin/fonts/MinionPro-Regular.ttf); }
                    @font-face { font-family: MinionProBold; src: url(resources/admin/fonts/MinionPro-Bold.ttf); }

                    p { font-family: MinionProRegular; text-indent: 45px; font-size: 17px; line-height: 100%;}
                    .title { font-family: MinionProBold; font-size: 25px; text-align: center;}
                    .strong { font-family: MinionProBold;}
                    .desc { padding-top: -20px; font-size: 15px;}
                    .nomargin { padding-top: -20px;}
                    .noindent { text-indent: 0px;}
                    .text-justify { text-align: justify;}
                    .text-right { text-align: right;}
                    .signature { padding-top: -20px; line-height: 1.3;}
                    img { width: 50%; margin-left: 80px;}
                    body{ padding-top: -40px; padding-left: -20px; padding-right: -20px; padding-bottom: -40px;};
            </style>

            </head>
            <body>
                <p class="title noindent">LEYLA\'DAN SONRA PROJESİ ONAY FORMU</p>
                <p class="text-justify">' . $text . '</p>
                <p class="desc">[Kutucuğu  <span class="strong">√ </span> (evet) olarak işaretlerseniz o bilginin paylaşılmasını onaylamış,<br>
                <span class="strong">X</span> (hayır) olarak işaretlerseniz onaylamamış olursunuz.]
                <img src="resources/admin/media/form_options.jpg">
                <p class="nomargin noindent text-justify">Leyla\'dan Sonra Projesi\'nde yer almayı ve iznim dahilindeki bilgilerin internet sitesi
                (www.leyladansonra.com), ilişkili sosyal medya hesaplarında (Facebook, Twitter, Instagram, Youtube)
                 ve tanıtım amaçlı mecralarda (sunumlar, haberler, vb...)  gizlilik esasları dikkate alınarak,
                  toplumda farkındalık yaratılması adına paylaşılmasını onaylıyor; bilgilerin projeye dahil olmayan
                   şahıslarca kullanılması durumunda bu sosyal sorumluluk projesinde görevli kişileri
                   sorumlu tutmayacağımı beyan ediyorum.</p>
                  <p class="noindent text-justify">İşbu onay formu velisi/vasisi bulunduğum ................................ T.C kimlik numaralı
                  ............................................ adına tarafımdan imzalanmıştır.</p>
                  <p class="text-right noindent signature">
                  …/…/……<br>
                    (..İMZA...…………….……………….)<br>
                    (..İSİM………………….……………..)<br>
                    (..TCKN………….….………..………)<br>
            </p>
            </body>
            </html>
        ';
        return PDF::loadHTML($form)
            ->setPaper('a5', 'portrait')
            ->setWarnings(false)
            ->stream('OnamFormu.pdf');

    }

    public function test(){
        /*
        $users = User::
            with('faculty')
            ->where('id', '>', '2928')
            ->whereHas('faculty', function($query) {
                $query->whereNotIn('code', [34, 35, 1]);
            })
            ->get();

        $i = 1;
        $count = count($users);
        foreach($users as $user){
            \Mail::send('email.admin.oylama', ['user' => $user], function ($message) use ($user) {
                $message
                    ->to(str_replace(' ', '', $user->email))
                    ->from('teknik@leyladansonra.com', 'Leyla\'dan Sonra Sistem')
                    ->subject("Leyla'dan Sonra 2017 Eğitim Kampı");
            });
            Log::info("User #" . $user->id . " sent. (" . $i . " / " . $count . ")");
            $i++;
        }

        dd($users);
**/

//        Newsletter::subscribe('murat@cakir.web.tr');
//        if(Newsletter::lastActionSucceeded())
//            return 'Success';
//        else
//            return Newsletter::getLastError();

//        $deviceToken = '7a6484ffcb2f2894550d0f166bde76c4f6d6e5089a77252fc155471ed25278ed';
////        PushNotification::app('appNameIOS')
////            ->to($deviceToken)
////            ->send('Hello World, i`m a push message');
//        $iOS = array(
//            'environment' =>'development',
//            'certificate' => app_path() . '/certificate.pem',
//            'passPhrase'  =>'',
//            'service'     =>'apns'
//        );
//
//        $message = PushNotification::Message('Kafamda bitti',array(
//            'badge' => 63,
//
//            'actionLocKey' => 'Action button title!',
//            'custom' => array('child_id' => 1)
//        ));
//
//        $collection = PushNotification::app($iOS)
//            ->to($deviceToken)
//            ->send($message);
//

        //FIXING CASES
//        $logs = [];
//        $bloods = \App\Blood::all();
//        foreach( $bloods as $blood){
//            $before = $blood->first_name . " " . $blood->last_name;
//            $blood->first_name = mb_convert_case(str_replace('i','İ',str_replace('I','ı',$blood->first_name)), MB_CASE_TITLE, "UTF-8");
//            $blood->last_name = mb_convert_case(str_replace('i','İ', str_replace('I','ı',$blood->last_name)), MB_CASE_TITLE, "UTF-8");
//            $after = $blood->first_name . " " . $blood->last_name;
//            if( $before != $after){
//                array_push($logs, $before . " => " . $after);
//                $blood->save();
//            }
//        }
//        dd($logs);


//        $chats = Chat::where('status', 'Açık')->with('child','volunteer')->get();
//        $logs = [];
//        foreach ($chats as $chat) {
//            $users = User::where('faculty_id', $chat->faculty_id)->whereIn('title', ['Fakülte Sorumlusu', 'İletişim Sorumlusu'])->get();
//            $volunteer = $chat->volunteer;
//            $child = $chat->child;
//
//            foreach ($users as $user) {
//                array_push($logs, "user: " . $user->full_name . "( ". $user->title . ") volunteer: " . $volunteer->first_name . " child: " . $child->full_name );
//
//                \Mail::send('email.admin.newmessage', ['user' => $user, 'volunteer' => $volunteer, 'child' => $child], function ($message) use ($user, $volunteer, $child) {
//                    $message
//                        ->to($user->email)
//                        ->from('teknik@leyladansonra.com', 'Leyladan Sonra Sistem')
//                        ->subject('Fakültenizde yeni mesaj var!');
//                });
//            }
//        }
//
//        dd($logs);
//        return 'Success';
    }

    public function sendEmail()
    {
        $user = User::find(1);

        \Mail::send('email.admin.activation', ['user' => $user], function ($message) use ($user) {
            $message
                ->to($user->email)
                ->from('teknik@leyladansonra.com', 'Leyladan Sonra Sistem')
                ->subject('Hesabınız artık aktif!');
        });
        return 'Success';
    }

    public function moving()
    {
        $faculties = DB::table('faculties')->where('id','<=', 36)->get();
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


    public function oylama(){
        return view('admin.oylama');
    }

    public function oylamaKaydet(Request $request){
        $user = Auth::user();
//        if($user->faculty->city == "İstanbul" || $user->faculty->city == "İzmir"){
//            Session::flash('error_message', 'Fakültesi <strong>İstanbul</strong> ya da <strong>İzmir</strong>\'de bulunanlar oy kullanamazlar.');
//            return view('admin.oylama');
//        }

        $oylar = DB::select('select * from oylar where used_by = ?', [$user->id]);
        if(count($oylar) > 0){
//            Session::flash('error_message', 'Daha önceden oy kullanmışsınız.');
//            return redirect()->back()->withInput();
            DB::update('delete from oylar where id = ?', [$oylar[0]->id]);
        }

        if( !($request->has('first') && $request->has('second')) ){
            Session::flash('error_message', 'Lütfen bütün tarihleri oylayınız.');
            return redirect()->back()->withInput();
        }

        Session::flash('success_message', 'Başarıyla oy kullandınız.');
        DB::insert('insert into oylar (used_by, faculty_name, first, second) values (?, ?, ?, ?)', [$user->id, $user->faculty->slug, $request->first, $request->second ]);

        return view('admin.oylama');
    }


}
