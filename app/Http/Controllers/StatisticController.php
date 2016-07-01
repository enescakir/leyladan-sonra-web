<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth, DB, App\Child, App\User, LaravelAnalytics, App\Chat, App\Faculty;
use Carbon\Carbon, Log;
use Facebook\Facebook, PDF;

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

        return view('admin.statistics.user', compact(['user', 'youngest', 'oldest', 'ageAve']));

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
            $avgTimes[ $faculty->full_name ] = number_format($avg, 2);
        }
        asort($avgTimes);

        return view('admin.statistics.volunteer', compact(['avgTimes']));
    }

    public function website()
    {
        $topKeywords = LaravelAnalytics::getTopKeywords(365,20);
        $topReferrers = LaravelAnalytics::getTopReferrers();
        $topBrowsers = LaravelAnalytics::getTopBrowsers();
        $mostVisitedPages = LaravelAnalytics::getMostVisitedPages();
        return view('admin.statistics.website', compact(['topKeywords','topReferrers','topBrowsers','mostVisitedPages']));
    }

    public function websiteVisitors()
    {
        $visitorsAndPageview = [[],[]];
        $vps = LaravelAnalytics::getVisitorsAndPageViews(60);
        Carbon::setLocale('tr');
        foreach ($vps as $vp){
            $date = new Carbon($vp['date']);
            array_push($visitorsAndPageview[0],  [$date->format('d.m.Y'), $vp['visitors']/1]);
            array_push($visitorsAndPageview[1],  [$date->format('d.m.Y'), $vp['pageViews']/1]);
        }
        return $visitorsAndPageview;
    }

    public function websiteActive()
    {
        return LaravelAnalytics::getActiveUsers();
    }

    public function facebook()
    {
        $fb = new Facebook([
            'app_id' => '1057935854286241',
            'app_secret' => 'c5834cbbb5a0e979aa1d1d1966553477',
            'default_graph_version' => 'v2.6',
            'default_access_token' => 'EAAPCLZBLKNaEBAFdqhqYQwsNwF1LWzFfEorhlzRjBcmyZCo8yYF8klQcpKNCqlcvgElllZCVFTbZAcOzzt9ExVSdi3IeDIDGJDZAzbRJwbIqt3tw7ZCUmorObUfAkbv4u2ugL78wrc4wFQQujZCpw7otUXL6vY5NoKLOU24iChrgwZDZD',
        ]);
        try {
            // Get the Facebook\GraphNodes\GraphUser object for the current user.
            // If you provided a 'default_access_token', the '{access-token}' is optional.
            $response = $fb->get('/1385092778379995/posts/');
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            return 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
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
            'app_id' => '1057935854286241',
            'app_secret' => 'c5834cbbb5a0e979aa1d1d1966553477',
            'default_graph_version' => 'v2.6',
            'default_access_token' => 'EAAPCLZBLKNaEBAFdqhqYQwsNwF1LWzFfEorhlzRjBcmyZCo8yYF8klQcpKNCqlcvgElllZCVFTbZAcOzzt9ExVSdi3IeDIDGJDZAzbRJwbIqt3tw7ZCUmorObUfAkbv4u2ugL78wrc4wFQQujZCpw7otUXL6vY5NoKLOU24iChrgwZDZD',
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

        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            return 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            return 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        $result = [];
        foreach( $post_insights as $post_insight){
            $result = array_add($result, $post_insight['name'],  $post_insight['values'][0]['value']);
        }

        $rapor = '
            <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
            <html lang="tr">
            <head>
            	<meta http-equiv="content-type" content="text/html; charset=utf-8">
            	<title>Rapor</title>
            	<link href="http://localhost:8000/resources/admin/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
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
                    .half-left { float:left; width:20%; background-color: #00A0D1 }
                    .half-right { float:right; width:20%; }
                    .content { width:100%; }
                    img { width: 50%; margin-left: 80px;}
                </style>


            </head>
            <body>
            <div class="content">
                <div class="row">
                    <div class="col-md-4">
                        Naber
                    </div>
                    <div class="col-md-4">
                        Naber
                    </div>
                </div>
            </div>
            </body>
            </html>
        ';
        return PDF::loadHTML($rapor)
            ->setPaper('a4', 'landscape')
            ->setWarnings(false)
            ->stream('rapor.pdf');

        return view('admin.statistics.facebook-post', compact(['result', 'post', 'post_attachments']));

    }


}
