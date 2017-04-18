<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\VolunteerMessageRequest;
use App\Child, App\Post, App\Faculty, App\News, App\Channel, App\User;
use App\Volunteer, App\Chat, App\Message, App\Testimonial, App\Blood, App\Sponsor;
use Log, DB, Validator, Cache, Mail, Carbon\Carbon, Newsletter;

class FrontController extends Controller
{
    //

    public function home(Request $request)
    {
        $page = $request->has('page') ? $request->page : '1';
        $children = Cache::remember('home-children' . $page, 10, function () {
            return Child::where('gift_state', 'Bekleniyor')
                ->with([
                    'meetingPosts',
                    'faculty',
                    'meetingPosts.images'])
                ->whereHas('posts', function ($query) {
                    $query->where('type', 'Tanışma')->approved();
                })
                ->where('until', '>', Carbon::now())
                ->orderby('meeting_day', 'desc')
                ->simplePaginate(20);
        });
//        $children = Child::where('gift_state', 'Bekleniyor')
//            ->with([
//                'meetingPosts',
//                'faculty',
//                'meetingPosts.images'])
//            ->whereHas('posts', function ($query) {
//                $query->approved()->where('type', 'Tanışma');
//            })
//            ->orderby('meeting_day','desc')
//            ->simplePaginate(20);
        return view('front.home', compact(['children']));
    }


    public function waitings(Request $request)
    {
        if ($request->isMethod('post')) {
            if ($request->secret == "burasicokgizli") {
                $children = Child::where('gift_state', 'Bekleniyor')
                    ->with([
                        'meetingPosts',
                        'faculty',
                        'meetingPosts.images'])
                    ->whereHas('posts', function ($query) {
                        $query->where('type', 'Tanışma')->approved();
                    })
                    ->orderby('meeting_day', 'desc')
                    ->get();

                return view('front.protected.waitings', compact(['children']));
            }
            else {
                return view('front.protected.login')->with('flash_message', 'Maalesef gizli kelimeyi bilemedin.');
            }
        }

        if ($request->isMethod('get')) {
            return view('front.protected.login');
        }

    }

    public function news()
    {
        $channels = Cache::remember('channels', 60, function () {
            return Channel::with('news')->get();
        });

        return view('front.news', compact(['channels']));
    }

    public function us()
    {

        $totalChildren = Cache::remember('totalChildren', 15, function () {
            return DB::table('children')->count();
        });

        $activeFaculties = Cache::remember('activeFaculties', 15, function () {
            return DB::table('faculties')->whereNotNull('started_at')->count();
        });

        $nonActiveFaculties = Cache::remember('nonActiveFaculties', 15, function () {
            return DB::table('faculties')->whereNull('started_at')->count();
        });

        $totalUser = Cache::remember('totalUser', 15, function () {
            return DB::table('users')->count();
        });

        return view('front.us', compact(['totalChildren', 'activeFaculties', 'nonActiveFaculties', 'totalUser']));
    }

    public function blood()
    {
        return view('front.blood');
    }

    public function bloodStore(Request $request)
    {

        $blood = Blood::where('mobile', $request->mobile)->first();
        if ($blood != null)
            return array('alert' => 'error', 'message' => '<span style="font-size: 24px"><br> Verdiğiniz telefon numarası zaten SMS sistemimizde kayıtlı.<br></br></span>');

//        $validator = Validator::make($request->all(), Blood::$validationRules, Blood::$validationMessages);

        $blood = new Blood($request->all());
        if ($blood->save()) {
            $text = '<span style="font-size: 24px"><br>' . $blood->city . ' şehrinde ' . $blood->blood_type . ' kan grubuna ihtiyaç durumunda vermiş olduğunuz ' . $blood->mobile . ' telefon numarası üzerinden SMS ile bildireceğiz.<br></br></span>';

            return array('alert' => 'success', 'message' => $text);
        }
    }


    public function privacy()
    {
        return view('front.privacy');
    }

    public function tos()
    {
        return view('front.tos');
    }

    public function contact()
    {
        return view('front.contact');
    }

    public function contactStore(Request $request)
    {
        $text = '<strong>Ad Soyad: </strong>' . $request->name . '<br>';
        $text .= '<strong>E-posta: </strong>' . $request->email . '<br>';
        $text .= '<strong>Telefon: </strong>' . $request->mobile . '<br>';
        $text .= '<strong>Mesaj: </strong><br>' . $request->message . '<br>';
        $text .= '<br><br><em>Bu mesaj sitedeki iletişim formu aracılığıyla ' . Carbon::now() . ' tarihinde oluşturulmuştur. </em>';

        \Mail::raw($text, function ($message) {
            $message->to('iletisim@leyladansonra.com')
                ->from('teknik@leyladansonra.com', 'Leyladan Sonra Sistem')
                ->subject('İletişim Formu');
        });

        $text = '<span style="font-size: 24px"><br>Mesajınız tarafımıza ulaştırmıştır.<br>İlgili arkadaşlarımız vermiş olduğunuz <strong>' . $request->email . '</strong> e-posta adresi üzerinden sizinle iletişime geçecektir. <br> İyilikle Kalın!<br></br></span>';

        return array('alert' => 'success', 'message' => $text);

    }

    public function newsletter(Request $request)
    {
        $text = '<span style="font-size: 24px"><br> Bu e-posta adresi zaten e-posta listemize kayıtlıdır. <br> İyilikle Kalın!<br></br></span>';

        if (Newsletter::hasMember($request->email))
            return array('alert' => 'success', 'message' => $text);

        Newsletter::subscribe($request->email);

        if (Newsletter::lastActionSucceeded()) {
            $text = '<span style="font-size: 24px"><br><strong>' . $request->email . '</strong> e-posta adresi listemize başarıyla eklendi. <br> İyilikle Kalın!<br></br></span>';

            return array('alert' => 'success', 'message' => $text);
        }
        else {
            $text = '<span style="font-size: 24px"><br Maalesef bir hata ile karşılaşıldı.<br> İyilikle Kalın!<br></br></span>';

            return array('alert' => 'success', 'message' => $text);
        }

    }

    public function sponsors()
    {
      $sponsors = Sponsor::orderBy('order', 'DESC')->get();
        // $channels = Cache::remember('channels', 60, function () {
        //     return Channel::with('news')->get();
        // });

        return view('front.sponsors', compact(['sponsors']));
    }

    public function testimonials()
    {
        $testimonials = Cache::remember('testimonials', 60, function () {
            return Testimonial::whereNotNull('approved_at')->get();
        });

        return view('front.testimonials', compact(['testimonials']));
    }

    public function newskit()
    {
        return view('front.newskit');
    }

    public function leyla()
    {
        return view('front.leyla');
    }

    public function sss()
    {
        return view('front.sss');
    }

    public function blogs()
    {
        return view('front.blogs');
    }

    public function appLanding()
    {
        $totalChildren = Cache::remember('totalChildren', 15, function() {
            return DB::table('children')->count();
        });

        $totalFaculties = Cache::remember('activeFaculties', 15, function() {
            return DB::table('faculties')->whereNotNull('started_at')->count();
        });


        return view('front.appLanding')->with([
            'totalChildren' => $totalChildren,
            'totalFaculties' => $totalFaculties
        ]);
    }

    public function blog($name)
    {
        return view('front.blog');
    }

    public function english()
    {
        $activeFaculties = Cache::remember('activeFaculties', 15, function () {
            return DB::table('faculties')->whereNotNull('started_at')->count();
        });

        $nonActiveFaculties = Cache::remember('nonActiveFaculties', 15, function () {
            return DB::table('faculties')->whereNull('started_at')->count();
        });

        return view('front.english', compact(['activeFaculties', 'nonActiveFaculties']));
    }

    public function faculties()
    {
        $faculties = Cache::remember('faculties', 60, function () {
            return Faculty::all();
        });

        return view('front.faculties', compact(['faculties']));
    }

    public function faculty(Request $request, $facultyName)
    {

        $faculty = Faculty::where('slug', $facultyName)->first();
        if ($faculty == null) {
            abort(404);
        }

        $page = $request->has('page') ? $request->page : '1';
        $children = Cache::remember($facultyName . '-children-' . $page, 10, function () use ($faculty) {
            return $faculty->children()
                ->with([
                    'posts',
                    'faculty',
                    'posts.images'])
                ->whereHas('posts', function ($query) {
                    $query->where('type', 'Tanışma')->approved();
                })
                ->where('until', '>', Carbon::now())
                ->orderby('meeting_day', 'desc')
                ->simplePaginate(20);
        });

        return view('front.faculty', compact(['faculty', 'children']));
    }

    public function child($facultyName, $childSlug)
    {

        $child = Cache::remember('child-' . $childSlug, 30, function () use ($childSlug) {
            return Child::where('slug', $childSlug)->with('faculty', 'posts', 'posts.images')->first();
        });

        if ($child == null || $child->faculty->slug != $facultyName) {
            abort(404);
        }

        if($child->until < Carbon::now()){
            return view('front.childExpired');
        }
        $children = Cache::remember('childRandom-' . $childSlug, 30, function () {
            return Child::where('gift_state', 'Bekleniyor')
                ->with([
                    'meetingPosts',
                    'faculty',
                    'meetingPosts.images' => function ($query) { $query->where('ratio', '4/3'); }])
                ->whereHas('posts', function ($query) {
                    $query->where('type', 'Tanışma')->approved();
                })
                ->whereHas('posts.images', function ($query) {
                    $query->where('ratio', '4/3');
                })
                ->orderby('meeting_day', 'desc')
                ->get();
        });
        $children = $children->random(min(10, $children->count()));
//        $nextPrev = Cache::remember('childNextPrev-' . $childSlug, 30, function () {
//            return Child::select('id', 'gift_state', 'slug', 'faculty_id')->with('faculty')->where('gift_state', 'Bekleniyor')->get()->random(2);
//        });
        $previousChild = $children->first();
        $nextChild = $children->last();

        return view('front.child', compact(['child', 'children', 'previousChild', 'nextChild']));
    }

    public function childMessage(VolunteerMessageRequest $request, $facultyName, $childSlug)
    {
        $child = Child::where('slug', $childSlug)->with('faculty')->first();

        $volunteer = Volunteer::where('email', $request->email)->first();
        if ($volunteer == null) {
            $volunteer = new Volunteer($request->only(['first_name', 'last_name', 'email', 'mobile', 'city']));
            $volunteer->save();
        }

        $chat = Chat::where('volunteer_id', $volunteer->id)->where('child_id', $child->id)->first();
        if ($chat == null) {
            $chat = new Chat([
                'volunteer_id' => $volunteer->id,
                'faculty_id'   => $child->faculty->id,
                'child_id'     => $child->id,
                'via'          => 'Web',
                'status'       => 'Açık'
            ]);
            $chat->save();
        }


        $message = new Message(['chat_id' => $chat->id, 'text' => $request->text]);
        $message->save();

//        $users = User::where('faculty_id', $child->faculty->id)->whereIn('title', ['Fakülte Sorumlusu', 'İletişim Sorumlusu'])->get();
        $users = User::where('faculty_id', $child->faculty->id)->where('title', 'İletişim Sorumlusu')->get();
        if(count($users) == 0){
            $users = User::where('faculty_id', $child->faculty->id)->where('title', 'Fakülte Sorumlusu')->get();
        }

        foreach ($users as $user) {
            \Mail::send('email.admin.newmessage', ['user' => $user, 'volunteer' => $volunteer, 'child' => $child], function ($message) use ($user, $volunteer, $child) {
                $message
                    ->to($user->email)
                    ->from('teknik@leyladansonra.com', 'Leyla\'dan Sonra Sistem')
                    ->subject('Fakültenizde yeni mesaj var!');
            });

        }

        $text = '<span style="font-size: 24px"><br><strong>' . $child->first_name . '</strong> isimli miniğimizin hediyesi ile ilgili talebiniz tarafımıza ulaştırmıştır.<br>İlgili arkadaşlarımız vermiş olduğunuz <strong>' . $volunteer->email . '</strong> e-posta adresi üzerinden sizinle iletişime geçecektir. <br> İyilikle Kalın!<br></br></span>';

        return array('alert' => 'success', 'message' => $text);
    }


    /**
     * Display a listing of faculty's children.
     *
     * @return Response
     */
    public function cities()
    {
        $coloredCities = Cache::remember('coloredCities', 60, function () {
            $cities = Faculty::all();
            $colored = [];
            foreach ($cities as $city) {
                if ($city->started_at == null) {
                    if (!array_has($colored, $city->code)) {
                        $colored[ $city->code ] = '#fcd5ae';
                    }
                }
                else {
                    $colored[ $city->code ] = '#339999';
                }
            }

            return $colored;
        });

        return $coloredCities;
    }

    public function city($code)
    {
        $cities = Faculty::where('code', $code)->get();

        return $cities;
    }


}
