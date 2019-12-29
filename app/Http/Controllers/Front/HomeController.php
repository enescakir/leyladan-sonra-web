<?php

namespace App\Http\Controllers\Front;

use App\Enums\GiftStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\VolunteerMessageRequest;
use App\Models\Child;
use App\Models\Faculty;
use App\Models\Channel;
use App\Models\User;
use App\Models\Volunteer;
use App\Models\Chat;
use App\Models\Message;
use App\Models\Testimonial;
use App\Models\Blood;
use App\Models\Sponsor;
use DB;
use Carbon\Carbon;
use Newsletter;

class HomeController extends Controller
{
    const SHORT_TERM_MINUTES = 15 * 60;
    const LONG_TERM_MINUTES = 60 * 60;


    public function home(Request $request)
    {
        $page = $request->has('page') ? $request->page : '1';

        $children = cache()->remember("home-children-{$page}", static::SHORT_TERM_MINUTES, function () {
            return Child::gift(GiftStatus::Waiting)
                ->with([
                    'meetingPost',
                    'meetingPost.media',
                    'faculty'
                ])
                ->whereHas('meetingPost', function ($query) {
                    $query->approved();
                })
                ->whereDate('until', '>', now())
                ->latest('meeting_day')
                ->simplePaginate(20);
        });

        return view('front.home', compact('children'));
    }

    public function news()
    {
        $channels = cache()->remember('channels', static::LONG_TERM_MINUTES, function () {
            return Channel::with('news')->get();
        });

        return view('front.news', compact('channels'));
    }

    public function us()
    {
        $counts = cache()->remember('us', static::LONG_TERM_MINUTES, function () {
            return [
                'children'              => Child::count(),
                'started-faculties'     => Faculty::started()->count(),
                'not-started-faculties' => Faculty::started(false)->count(),
                'users'                 => User::count(),
            ];
        });

        return view('front.us', compact($counts));
    }

    public function blood()
    {
        return view('front.blood');
    }

    public function bloodStore(Request $request)
    {
        $blood = Blood::where('mobile', $request->mobile)->first();
        if ($blood != null) {
            return [
                'alert'   => 'error',
                'message' => '<span style="font-size: 24px"><br> Verdiğiniz telefon numarası zaten SMS sistemimizde kayıtlı.<br></br></span>'
            ];
        }

        $blood = Blood::create(
            $request->only([
                'mobile',
                'city',
                'blood_type',
                'rh'
            ])
        );

        if ($blood) {
            $text = "<span style='font-size: 24px'><br>{$blood->city} şehrinde {$blood->blood_type} kan grubuna ihtiyaç durumunda vermiş olduğunuz {$blood->mobile} telefon numarası üzerinden SMS ile bildireceğiz.<br></br></span>";

            return [
                'alert'   => 'success',
                'message' => $text
            ];
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
                ->from('teknik@leyladansonra.com', 'Leyla\'dan Sonra Sistem')
                ->subject('İletişim Formu');
        });

        $text = "<span style='font-size: 24px'><br>Mesajınız tarafımıza ulaştırmıştır.<br>İlgili arkadaşlarımız vermiş olduğunuz <strong> {$request->email}</strong> e-posta adresi üzerinden sizinle iletişime geçecektir. <br> İyilikle Kalın!<br></br></span>";

        return [
            'alert'   => 'success',
            'message' => $text
        ];
    }

    public function newsletter(Request $request)
    {
        $text = "<span style='font-size: 24px'><br> Bu e-posta adresi zaten e-posta listemize kayıtlıdır. <br> İyilikle Kalın!<br></br></span>";

        if (Newsletter::hasMember($request->email)) {
            return ['alert' => 'success', 'message' => $text];
        }

        Newsletter::subscribe($request->email);

        if (Newsletter::lastActionSucceeded()) {
            $text = '<span style="font-size: 24px"><br><strong>' . $request->email . '</strong> e-posta adresi listemize başarıyla eklendi. <br> İyilikle Kalın!<br></br></span>';

            return ['alert' => 'success', 'message' => $text];
        } else {
            $text = '<span style="font-size: 24px"><br Maalesef bir hata ile karşılaşıldı.<br> İyilikle Kalın!<br></br></span>';

            return ['alert' => 'success', 'message' => $text];
        }
    }

    public function sponsors()
    {
        $sponsors = cache()->remember('sponsors', static::LONG_TERM_MINUTES, function () {
            return Sponsor::orderBy('order', 'DESC')->get();
        });

        return view('front.sponsors', compact('sponsors'));
    }

    public function testimonials()
    {
        $testimonials = cache()->remember('testimonials', static::LONG_TERM_MINUTES, function () {
            return Testimonial::whereNotNull('approved_at')->orderBy('priority', 'DESC')->get();
        });

        return view('front.testimonials', compact('testimonials'));
    }

    public function testimonialStore(Request $request)
    {
        $testimonial = new Testimonial($request->all());
        $testimonial->via = 'Site';
        if ($testimonial->save()) {
            $text = '<span style="font-size: 24px"><br>' . $testimonial->name . ' mesajınız başarıyla alınmıştır.<br></br></span>';
            return ['alert' => 'success', 'message' => $text];
        } else {
            $text = '<span style="font-size: 24px"><br> Bir sorun ile karşılaşıldı :( <br></br></span>';
            return ['alert' => 'error', 'message' => $text];
        }
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
        $counts = cache()->remember('app-landing', static::LONG_TERM_MINUTES, function () {
            return [
                'children'          => Child::count(),
                'started-faculties' => Faculty::started()->count(),
            ];
        });

        return view('front.appLanding', compact('counts'));
    }

    public function blog($name)
    {
        return view('front.blog');
    }

    public function english()
    {

        $counts = cache()->remember('english', static::LONG_TERM_MINUTES, function () {
            return [
                'started-faculties'     => Faculty::started()->count(),
                'not-started-faculties' => Faculty::started(false)->count(),
            ];
        });

        return view('front.english', compact('counts'));
    }

    public function faculties()
    {
        $faculties = cache()->remember('faculties', static::LONG_TERM_MINUTES, function () {
            return Faculty::all();
        });

        return view('front.faculties', compact('faculties'));
    }

    public function faculty(Request $request, $facultyName)
    {
        $faculty = Faculty::slug($facultyName)->firstOrFail();

        $page = $request->has('page') ? $request->page : '1';
        $children = cache()->remember("{$facultyName}-children-{$page}", static::SHORT_TERM_MINUTES, function () use ($faculty) {
            return $faculty->children()
                ->with([
                    'meetingPost',
                    'meetingPost.media',
                    'deliveryPost',
                    'deliveryPost.media',
                    'faculty'
                ])
                ->whereHas('meetingPost', function ($query) {
                    $query->approved();
                })
                ->whereDate('until', '>', now())
                ->latest('meeting_day')
                ->simplePaginate(20);
        });

        return view('front.faculty', compact('faculty', 'children'));
    }

    public function child($facultyName, $childSlug)
    {
        $child = cache()->remember('child-' . $childSlug, static::SHORT_TERM_MINUTES, function () use ($childSlug) {
            return Child::where('slug', $childSlug)->with('faculty', 'posts', 'posts.images')->first();
        });

        if ($child == null || $child->faculty->slug != $facultyName) {
            abort(404);
        }

        if ($child->until < Carbon::now()) {
            return view('front.childExpired');
        }
        $children = cache()->remember('childRandom-' . $childSlug, static::SHORT_TERM_MINUTES, function () {
            return Child::where('gift_state', 'Bekleniyor')
                ->with([
                    'meetingPosts',
                    'faculty',
                    'meetingPosts.images' => function ($query) {
                        $query->where('ratio', '4/3');
                    }])
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
//        $nextPrev = cache()->remember('childNextPrev-' . $childSlug, 30, function () {
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
        if (count($users) == 0) {
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

        return ['alert' => 'success', 'message' => $text];
    }

    public function cities()
    {
        $coloredCities = cache()->remember('coloredCities', static::LONG_TERM_MINUTES, function () {
            $cities = Faculty::all();
            $colored = [];
            foreach ($cities as $city) {
                if ($city->started_at == null) {
                    if (!array_has($colored, $city->code)) {
                        $colored[$city->code] = '#fcd5ae';
                    }
                } else {
                    $colored[$city->code] = '#339999';
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
