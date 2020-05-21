<?php

namespace App\Http\Controllers\Front;

use App\Enums\GiftStatus;
use App\Models\Question;
use App\Services\NotificationService;
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
use Mail;
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
                ->with(['featuredMedia', 'faculty'])
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
            return Channel::with('news', 'media')->get();
        });

        return view('front.news', compact('channels'));
    }

    public function us()
    {
        $counts = cache()->remember('us', static::LONG_TERM_MINUTES, function () {
            return [
                'bloods'                => Blood::count(),
                'children'              => Child::count(),
                'started-faculties'     => Faculty::started()->count(),
                'not-started-faculties' => Faculty::started(false)->count(),
                'users'                 => User::approved()
                    ->whereNull('left_at')
                    ->whereNull('graduated_at')
                    ->whereHas('faculty', function ($query) {
                        $query->stopped(false);
                    })->count(),
            ];
        });

        return view('front.us', compact('counts'));
    }

    public function blood()
    {
        $cities = citiesToSelect(false, "-- Seçiniz... --");

        return view('front.blood', compact('cities'));
    }

    public function bloodStore(Request $request)
    {
        $mobile = make_mobile($request->mobile);
        $blood = Blood::where('mobile', $mobile)->withTrashed()->first();

        if ($blood && $blood->trashed()) {
            $blood->restore();
            $blood->update($request->only([
                'city',
                'blood_type',
                'rh'
            ]));
            return $this->successMessage("{$blood->city} şehrinde {$blood->blood_type} kan grubuna ihtiyaç durumunda vermiş olduğunuz {$blood->mobile} telefon numarası üzerinden SMS ile bildireceğiz.");
        }

        if ($blood != null) {
            return $this->errorMessage('Verdiğiniz telefon numarası zaten SMS sistemimizde kayıtlı.');
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
            return $this->successMessage("{$blood->city} şehrinde {$blood->blood_type} kan grubuna ihtiyaç durumunda vermiş olduğunuz {$blood->mobile} telefon numarası üzerinden SMS ile bildireceğiz.");
        }

        return $this->errorMessage('Beklenmedik bir sorunla karşılaşıldı.');
    }

    public function bloodDeleteForm()
    {
        return view('front.bloodDelete');
    }

    public function bloodDelete(Request $request)
    {
        if ($request->has('g-recaptcha-response')) {
            $recaptcha_secret = config('services.recaptcha.secret');
            $recaptcha_response = $request->get('g-recaptcha-response');
            $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$recaptcha_secret}&response={$recaptcha_response}");

            $g_response = json_decode($response);
            if ($g_response->success !== true) {
                return $this->errorMessage("Robot olmadığınızı doğrulayamadınız");
            }
        } else {
            return $this->errorMessage("Robot olmadığınızı doğrulayamadınız");
        }

        $mobile = make_mobile($request->mobile);
        $blood = Blood::where('mobile', $mobile)->first();
        if ($blood) {
            $blood->delete();

            return $this->successMessage("Verdiğiniz telefon numarası SMS sistemimizden silinmiştir.");
        } else {
            return $this->errorMessage("Verdiğiniz telefon numarası zaten SMS sistemimize kayıtlı değildir.");
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
        $text = "<strong>Ad Soyad: </strong>{$request->name}<br>";
        $text .= "<strong>E-posta: </strong>{$request->email}<br>";
        $text .= "<strong>Telefon: </strong>{$request->mobile}<br>";
        $text .= "<strong>Mesaj: </strong><br>{$request->message}<br>";
        $text .= "<br><br><small><em>Bu mesaj sitedeki iletişim formu aracılığıyla " . now()->format('d.m.Y H:i:s') . " tarihinde oluşturulmuştur. </em></small>";

        Mail::html($text, function ($message) use ($request) {
            $message->to('iletisim@leyladansonra.com')
                ->replyTo($request->email, $request->name)
                ->subject('İletişim Formu');
        });

        return $this->successMessage("Mesajınız tarafımıza ulaştırmıştır.<br>İlgili arkadaşlarımız vermiş olduğunuz <strong> {$request->email}</strong> e-posta adresi üzerinden sizinle iletişime geçecektir. <br> İyilikle Kalın!");
    }

    public function newsletter(Request $request)
    {
        if (Newsletter::hasMember($request->email)) {
            return $this->successMessage("<strong>{$request->email}</strong> adresi zaten e-posta listemize kayıtlıdır. <br> İyilikle Kalın!");
        }

        Newsletter::subscribe($request->email);

        return Newsletter::lastActionSucceeded()
            ? $this->successMessage("<strong>{$request->email}</strong> e-posta adresi listemize başarıyla eklendi. <br> İyilikle Kalın!")
            : $this->errorMessage("Maalesef bir hata ile karşılaşıldı.<br> İyilikle Kalın!");
    }

    public function sponsors()
    {
        $sponsors = cache()->remember('sponsors', static::LONG_TERM_MINUTES, function () {
            return Sponsor::with('media')->orderBy('order', 'DESC')->get();
        });

        return view('front.sponsors', compact('sponsors'));
    }

    public function testimonials()
    {
        $testimonials = cache()->remember('testimonials', static::LONG_TERM_MINUTES, function () {
            return Testimonial::approved()->orderBy('priority', 'DESC')->get();
        });

        return view('front.testimonials', compact('testimonials'));
    }

    public function testimonialStore(Request $request)
    {
        $testimonial = new Testimonial($request->only('name', 'text', 'email'));
        $testimonial->via = 'Site';

        return $testimonial->save()
            ? $this->successMessage("<strong>{$testimonial->name}</strong> mesajınız başarıyla alınmıştır.")
            : $this->errorMessage("Bir sorun ile karşılaşıldı :(");
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
        $questions = cache()->remember('questions', static::LONG_TERM_MINUTES, function () {
            return Question::orderBy('order', 'DESC')->get();
        });

        return view('front.sss', compact('questions'));
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
            return Faculty::with('media')->get();
        });

        return view('front.faculties', compact('faculties'));
    }

    public function faculty(Request $request, $facultySlug)
    {
        $faculty = Faculty::findBySlugOrFail($facultySlug);

        $page = $request->has('page') ? $request->page : '1';
        $children = cache()->remember("{$facultySlug}-children-{$page}", static::SHORT_TERM_MINUTES, function () use ($faculty) {
            return $faculty->children()
                ->with(['featuredMedia'])
                ->whereHas('meetingPost', function ($query) {
                    $query->approved();
                })
                ->whereDate('until', '>', now())
                ->latest('meeting_day')
                ->simplePaginate(20);
        });

        return view('front.faculty', compact('faculty', 'children'));
    }

    public function child($facultySlug, $childSlug)
    {
        $child = cache()->remember("child-{$childSlug}", static::SHORT_TERM_MINUTES, function () use ($childSlug) {
            return Child::where('slug', $childSlug)
                ->with('faculty', 'faculty.media', 'featuredMedia', 'meetingPost', 'meetingPost.media', 'deliveryPost', 'deliveryPost.media')
                ->firstOrFail();
        });

        if ($child->faculty->slug != $facultySlug) {
            abort(404);
        }

        if (!optional($child->meetingPost)->isApproved()) {
            abort(404);
        }

        if (now()->isAfter($child->until)) {
            return view('front.childExpired');
        }

        $similarChildren = cache()->remember("childRandom-{$childSlug}", static::SHORT_TERM_MINUTES, function () use ($child) {
            return Child::where('gift_state', GiftStatus::Waiting)
                ->with(['faculty', 'featuredMedia'])
                ->whereHas('meetingPost', function ($query) {
                    $query->approved();
                })
                ->whereDate('until', '>', now())
                ->where('id', '<>', $child->id)
                ->latest('meeting_day')
                ->inRandomOrder()
                ->limit(12)
                ->get();
        });

        $prevChild = $similarChildren->first();
        $nextChild = $similarChildren->last();

        return view('front.child', compact('child', 'similarChildren', 'prevChild', 'nextChild'));
    }

    public function childMessage(VolunteerMessageRequest $request, $facultySlug, $childSlug)
    {
        $child = Child::where('slug', $childSlug)->with('faculty')->first();

        $volunteer = Volunteer::where('email', $request->email)->first();
        if ($volunteer == null) {
            $volunteer = Volunteer::create($request->only(['first_name', 'last_name', 'email', 'mobile', 'city']));
        }

        $chat = Chat::where('volunteer_id', $volunteer->id)->where('child_id', $child->id)->first();
        if ($chat == null) {
            $chat = Chat::create([
                'volunteer_id' => $volunteer->id,
                'faculty_id'   => $child->faculty->id,
                'child_id'     => $child->id,
                'via'          => 'Web',
                'status'       => 'Açık'
            ]);
        }

        $message = Message::create(['chat_id' => $chat->id, 'text' => $request->text]);

        NotificationService::sendMessageReceivedNotification($chat);

        return $this->successMessage("<strong>{$child->safe_name}</strong> isimli miniğimizin hediyesi ile ilgili talebiniz tarafımıza ulaştırmıştır.<br>İlgili arkadaşlarımız vermiş olduğunuz <strong>{$volunteer->email}</strong> e-posta adresi üzerinden sizinle iletişime geçecektir. <br> İyilikle Kalın!");
    }

    public function admin(Request $request)
    {
        return redirect()->route('admin.login');
    }

    public function cities()
    {
        $coloredCities = cache()->remember('coloredCities', static::LONG_TERM_MINUTES, function () {
            $faculties = Faculty::all();
            $colored = [];
            foreach ($faculties as $faculty) {
                if (!$faculty->isStarted()) {
                    if (!array_has($colored, $faculty->code)) {
                        $colored[$faculty->code] = '#fcd5ae';
                    }
                } else {
                    $colored[$faculty->code] = '#339999';
                }
            }

            return $colored;
        });

        return $coloredCities;
    }

    public function city($code)
    {
        $faculties = Faculty::where('code', $code)->get();

        return $faculties;
    }

    private function successMessage($message)
    {
        return [
            'alert'   => 'success',
            'message' => "<span style='font-size: 24px; padding: 10px;'>{$message}</span>"
        ];
    }

    private function errorMessage($message)
    {
        return [
            'alert'   => 'error',
            'message' => "<span style='font-size: 24px; padding: 10px;'>{$message}</span>"
        ];
    }
}
