<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth, DB, App\Child, App\User, LaravelAnalytics, App\Chat, App\Faculty, App\Process, App\Blood;
use Carbon\Carbon, Log;
use Facebook\Facebook, PDF;

class StatisticController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
    }

    public function children_by_general()
    {
        $result = DB::select("SELECT COUNT(*) as count, YEAR(meeting_day) as year, MONTHNAME(meeting_day) as month FROM children GROUP BY year, MONTH(meeting_day) ORDER BY year DESC, MONTH(meeting_day) DESC LIMIT 10;");

        $childrenCount = [];
        foreach ($result as $key => $value) {
            array_push($childrenCount, array(substr($value->month, 0, 3), $value->count));
        }

        return array_reverse($childrenCount);
    }

    public function children_by_faculty($id)
    {
        $result = DB::select("SELECT COUNT(*) as count, YEAR(meeting_day) as year, MONTHNAME(meeting_day) as month FROM children WHERE faculty_id = " . $id . " GROUP BY year, MONTH(meeting_day) ORDER BY year DESC, MONTH(meeting_day) DESC LIMIT 10;");

        $childrenCount = [];
        foreach ($result as $key => $value) {
            array_push($childrenCount, array(substr($value->month, 0, 3), $value->count));
        }

        return array_reverse($childrenCount);
    }

    public function user()
    {
        $user = Auth::user();
        $youngest = User::select('birthday')->orderby('birthday', 'desc')->first();
        $oldest = User::select('birthday')->orderby('birthday')->first();
        $ageAve = DB::select("SELECT AVG(TIMESTAMPDIFF(YEAR, birthday, CURDATE())) AS `average` FROM users;")[0];
        $visits = User::with('faculty')->withCount('visits')->limit(10)->orderby('visits_count', 'desc')->get();
        $meetings = User::with('faculty')->withCount('children')->limit(10)->orderby('children_count', 'desc')->get();
        return view('admin.statistics.user', compact(['user', 'youngest', 'oldest', 'ageAve', 'visits', 'meetings']));

    }

    public function userHoroscope()
    {
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
        $horoscope = array($koc, $boga, $ikizler, $yengec, $aslan, $basak, $terazi, $akrep, $yay, $oglak, $kova, $balik);

        return $horoscope;
    }

    public function volunteer()
    {
        $chats = Chat::all();
        $avgTimes = [];
        $chats = $chats->groupBy('faculty_id');
        foreach ($chats as $index => $chat) {
            $sum = 0;
            foreach ($chat as $c) {
                $sum += $c->avgTime();
            }
            $avg = $sum / count($chat);
            $faculty = Faculty::find($index);
            $avgTimes[ $faculty->full_name ] = [ number_format($avg, 2,".",""), $faculty->chats()->where('status', 'Açık')->count()];
        }
        asort($avgTimes);
        $children = Child::where('gift_state', 'Bekleniyor')
            ->with([ 'faculty','chats'])
            ->whereHas('posts', function ($query) {
                $query->where('type', 'Tanışma')->approved();
            })
            ->orderby('meeting_day', 'desc')
            ->get();
        return view('admin.statistics.volunteer', compact(['avgTimes', 'children']));
    }

    public function child()
    {
        $youngest = Child::orderby('birthday', 'desc')->first();
        $oldest = Child::orderby('birthday')->first();
        $ageAve = DB::select("SELECT AVG(TIMESTAMPDIFF(YEAR, birthday, CURDATE())) AS `average` FROM children;")[0];
        $cities = DB::table('children')->select('city', DB::raw('count(*) as count'))->groupBy('city')->get();
        usort($cities, function ($a, $b) { return $b->count - $a->count; });
        $diagnosises = DB::table('children')->select('diagnosis', DB::raw('count(*) as count'))->groupBy('diagnosis')->get();
        usort($diagnosises, function ($a, $b) { return $b->count - $a->count; });

        return view('admin.statistics.child', compact(['youngest', 'oldest', 'ageAve', 'cities', 'diagnosises']));
    }

    public function childDepartment()
    {
        $departments = DB::table('children')->select('department', DB::raw('count(*) as number'))->groupBy('department')->get();
        return $departments;
    }

    public function blood()
    {
        $youngest = Blood::orderby('birthday', 'desc')->first();
        $oldest = Blood::orderby('birthday')->first();
        $ageAve = DB::select("SELECT AVG(TIMESTAMPDIFF(YEAR, birthday, CURDATE())) AS `average` FROM bloods;")[0];
        $heightAve = DB::select("SELECT AVG(height) AS `average` FROM bloods;")[0];
        $weightAve = DB::select("SELECT AVG(weight) AS `average` FROM bloods;")[0];

        $cities = DB::table('bloods')->select('city', DB::raw('count(*) as count'))->groupBy('city')->get();
        usort($cities, function ($a, $b) { return $b->count - $a->count; });

        return view('admin.statistics.blood', compact(['youngest', 'oldest', 'ageAve', 'cities', 'heightAve', 'weightAve']));
    }

    public function bloodRh()
    {
        $rhs = DB::table('bloods')->select('rh', DB::raw('count(*) as number'))->groupBy('rh')->get();
        return $rhs;
    }

    public function bloodType()
    {
        $types = DB::table('bloods')->select('blood_type', DB::raw('count(*) as number'))->groupBy('blood_type')->get();
        return $types;
    }

    public function bloodGender()
    {
        $genders = DB::table('bloods')->select('gender', DB::raw('count(*) as number'))->groupBy('gender')->get();
        return $genders;
    }

    public function faculty()
    {
        $datas = Faculty::whereNotNull('started_at')->get();
        $faculties = [];

        foreach ($datas as $key => $faculty) {
            $object = new \stdClass();
            $object->name = $faculty->full_name . " Tıp Fakültesi";
            $object->waiting = DB::table('children')->where('faculty_id', $faculty->id)->where('gift_state', 'Bekleniyor')->count();
            $object->road = DB::table('children')->where('faculty_id', $faculty->id)->where('gift_state', 'Yolda')->count();
            $object->arrived = DB::table('children')->where('faculty_id', $faculty->id)->where('gift_state', 'Bize Ulaştı')->count();
            $object->delivered = DB::table('children')->where('faculty_id', $faculty->id)->where('gift_state', 'Teslim Edildi')->count();
            $object->total = DB::table('children')->where('faculty_id', $faculty->id)->count();

            if ($faculty->slug == "istanbultip") {
                $object->delivered = $object->delivered + 100;
                $object->total = $object->total + 100;
            }
            array_push($faculties, $object);
        }

        usort($faculties, function ($a, $b) {
            return $b->total - $a->total;
        });

        return view('admin.statistics.faculty', compact(['faculties']));
    }

    public function website()
    {
        $topKeywords = LaravelAnalytics::getTopKeywords(365, 20);
        $topReferrers = LaravelAnalytics::getTopReferrers();
        $topBrowsers = LaravelAnalytics::getTopBrowsers();
        $mostVisitedPages = LaravelAnalytics::getMostVisitedPages();

        return view('admin.statistics.website', compact(['topKeywords', 'topReferrers', 'topBrowsers', 'mostVisitedPages']));
    }

    public function websiteVisitors()
    {
        $visitorsAndPageview = [[], []];
        $vps = LaravelAnalytics::getVisitorsAndPageViews(60);
        Carbon::setLocale('tr');
        foreach ($vps as $vp) {
            $date = new Carbon($vp['date']);
            array_push($visitorsAndPageview[0], [$date->format('d.m.Y'), $vp['visitors'] / 1]);
            array_push($visitorsAndPageview[1], [$date->format('d.m.Y'), $vp['pageViews'] / 1]);
        }

        return $visitorsAndPageview;
    }

    public function websiteActive()
    {
        return LaravelAnalytics::getActiveUsers();
    }


    // =========== TEST =========== TEST ============ TEST ===============
    public function facebook()
    {
        $fb = new Facebook([
            'app_id'                => '1057935854286241',
            'app_secret'            => 'c5834cbbb5a0e979aa1d1d1966553477',
            'default_graph_version' => 'v2.6',
            'default_access_token'  => 'EAAPCLZBLKNaEBAFdqhqYQwsNwF1LWzFfEorhlzRjBcmyZCo8yYF8klQcpKNCqlcvgElllZCVFTbZAcOzzt9ExVSdi3IeDIDGJDZAzbRJwbIqt3tw7ZCUmorObUfAkbv4u2ugL78wrc4wFQQujZCpw7otUXL6vY5NoKLOU24iChrgwZDZD',
        ]);
        try {
            // Get the Facebook\GraphNodes\GraphUser object for the current user.
            // If you provided a 'default_access_token', the '{access-token}' is optional.
            $response = $fb->get('/1385092778379995/posts/');
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            return 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            return 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        $d = $response->getDecodedBody();

        return view('admin.statistics.facebook', compact('d'));
    }


    public function facebookPost($id)
    {
        $fb = new Facebook([
            'app_id'                => '1057935854286241',
            'app_secret'            => 'c5834cbbb5a0e979aa1d1d1966553477',
            'default_graph_version' => 'v2.6',
            'default_access_token'  => 'EAAPCLZBLKNaEBAFdqhqYQwsNwF1LWzFfEorhlzRjBcmyZCo8yYF8klQcpKNCqlcvgElllZCVFTbZAcOzzt9ExVSdi3IeDIDGJDZAzbRJwbIqt3tw7ZCUmorObUfAkbv4u2ugL78wrc4wFQQujZCpw7otUXL6vY5NoKLOU24iChrgwZDZD',
        ]);


//        $post = $fb->get('/' . $id . '/attachments')->getDecodedBody()['data'][0];
//        $post_impressions_unique = $fb->request('GET', '/' . $id . '/insights/post_impressions_unique'); //People Reached
//        $post_consumption = $fb->request('GET', '/' . $id . '/insights/post_consumptions'); // Post-clicks
//        $post_consumptions_by_type_unique = $fb->request('GET', '/' . $id . '/insights/post_consumptions_by_type_unique'); // Post-detailed-clicks
//        $post_stories = $fb->request('GET', '/' . $id . '/insights/post_stories'); // Likes, comment total
//        $post_stories_by_action_type = $fb->request('GET', '/' . $id . '/insights/post_stories_by_action_type'); // Likes, comment totally, separated
//        $post_storytellers_by_action_type = $fb->request('GET', '/' . $id . '/insights/post_story_adds_unique'); // Likes, comment on post, separated
//
//
//        $batch = [
//            'post_impressions_unique' => $post_impressions_unique,
//            'post_consumption' => $post_consumption,
//            'post_consumptions_by_type_unique' => $post_consumptions_by_type_unique,
//            'post_stories' => $post_stories,
//            'post_stories_by_action_type' => $post_stories_by_action_type,
//            'post_storytellers_by_action_type' => $post_storytellers_by_action_type,
//        ];
//
//        $responses = $fb->sendBatchRequest($batch);
//
//        $result = [];
//        foreach( $responses as $response){
//            $data = $response->getDecodedBody()['data'];
//            $result = array_add($result, $data[0]['name'],  $data[0]['values'][0]['value']);
//        }
//        dd($result);
//        return view('admin.statistics.facebook-post', compact(['result', 'post']));


        try {
            // Get the Facebook\GraphNodes\GraphUser object for the current user.
            // If you provided a 'default_access_token', the '{access-token}' is optional.
            $post = $fb->get('/' . $id)->getDecodedBody();
            $post_attachments = $fb->get('/' . $id . '/attachments')->getDecodedBody()['data'][0];
            $post_insights = $fb->get('/' . $id . '/insights')->getDecodedBody()['data'];

        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            return 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            return 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        $result = [];
        foreach ($post_insights as $post_insight) {
            $result = array_add($result, $post_insight['name'], $post_insight['values'][0]['value']);
        }

//        @if( $post_attachments['type'] == 'photo')
//                        <img src="{{ $post_attachments['media']['image']['src'] }}" style="width:70%;">
//        @elseif($post_attachments['type'] == 'album')
//                        @foreach( $post_attachments['subattachments']['data'] as $photo)
//                            <img src="{{ $photo['media']['image']['src'] }}" style="width:45%; margin-right: 5px;">
//        @endforeach
//                    @endif


        return view('admin.statistics.facebook-post', compact(['result', 'post', 'post_attachments']));

    }

    public function facebookPDF($id)
    {
//        $text = '<!DOCTYPE html><html lang="tr"><head><meta charset="utf-8"/>
//    <title>Gönderiler</title><link href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet"
//          type="text/css"/></head><body><div class="container" style="margin-top: 40px;"><div class="row"><div class="col-md-2"></div>
//        <div class="col-md-8"><div class="row"><div class="col-md-6"><p>' . nl2br($post['message']) . '</p></div>
//                <div class="col-md-6">
//                    <h2> ' . $result['post_impressions_unique'] . '
//                        <small> People Reached</small>
//                    </h2>
//                    <h2> ' . $result['post_stories'] . '
//                        <small> Likes, Comments & Shares</small>
//                    </h2>
//                    <table class="table table-bordered">
//                        <tbody>
//                        <tr>
//                            <td><h4><strong> ' . $result['post_stories_by_action_type']['like'] . ' </strong></h4> Likes</td>
//                            <td><h4><strong> ' . $result['post_stories_by_action_type']['like'] . ' </strong></h4> On Post</td>
//                            <td><h4><strong> 2 </strong></h4> On Shares</td>
//                        </tr>
//                        <tr>
//                            <td><h4><strong>  48 </strong></h4> Comments</td>
//                            <td><h4><strong>  48 </strong></h4>On Post</td>
//                            <td><h4><strong> 0 </strong></h4> On Shares</td>
//                        </tr>
//                        <tr>
//                            <td><h4><strong> ' . $result['post_stories_by_action_type']['share'] . ' </strong></h4> Shares</td>
//                            <td><h4><strong> ' . $result['post_stories_by_action_type']['share'] . ' </strong></h4> On Post</td>
//                            <td><h4><strong> 0 </strong></h4> On Shares</td>
//                        </tr>
//                        </tbody>
//                    </table>
//                    <h2> ' . $result['post_consumptions'] . '
//                        <small> Post Clicks</small>
//                    </h2>
//                    <table class="table table-bordered">
//                        <tbody>
//                        <tr>
//                            <td><h4><strong> ' . $result['post_consumptions_by_type']['photo view'] . ' </strong></h4> Photo Views</td>
//                            <td><h4><strong> ' . $result['post_consumptions_by_type']['link clicks'] . ' </strong></h4> Link Clicks</td>
//                            <td><h4><strong> ' . $result['post_consumptions_by_type']['other clicks'] . ' </strong></h4> Other Clicks</td>
//                        </tr>
//                        </tbody>
//                    </table>
//                    <h5><strong> NEGATIVE FEEDBACK</strong></h5>
//                    <div class="row">
//                        <div class="col-md-6">
//                            <p> <strong> 0 </strong> <small> Hide Post</small></p>
//                            <p> <strong> 0 </strong> <small> Report as Spam</small></p>
//                        </div>
//                        <div class="col-md-6">
//                            <p> <strong> 0 </strong> <small> Hide All Posts</small></p>
//                            <p> <strong> 0 </strong> <small> Unlike Page</small></p></div></div></div></div></div></div>
//                    </div></body></html>';
//
//        return PDFS::loadHtml($text)->inline('rapor.pdf');
    }


}
