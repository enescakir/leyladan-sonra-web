<?php

namespace App\Http\Controllers;

use App\Faculty;
use Illuminate\Http\Request;

use Auth, DB, PDF, Cache;
use App\Feed;

class DashboardController extends Controller
{
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

    public function blank()
    {
      return view('admin.blank');
    }

    public function materials()
    {
      return view('admin.materials');
    }

    public function manual()
    {
      return view('admin.manual');
    }

    public function createForm()
    {
      return view('admin.createForm');
    }

    public function storeForm(Request $request)
    {
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

    public function test()
    {

    }

    public function vote()
    {
      return view('admin.oylama');
    }

    public function voteStore(Request $request)
    {
      $user = Auth::user();
      $votes = DB::select('select * from votes where used_by = ?', [$user->id]);
      if (count($votes) > 0) {
        session_error('Daha önceden oy kullanmışsınız');
        return redirect()->back()->withInput();
      }
      if( !($request->has('first') && $request->has('second')) ){
        session_error('Lütfen bütün tarihleri oylayınız');
        return redirect()->back()->withInput();
      }

      session_succes('Başarıyla oy kullandınız');
      DB::insert('insert into votes (used_by, faculty_name, first, second) values (?, ?, ?, ?)', [$user->id, $user->faculty->slug, $request->first, $request->second ]);

      return view('admin.vote');
    }
}
