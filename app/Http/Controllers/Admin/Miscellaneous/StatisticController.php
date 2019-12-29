<?php
// TODO: Refactor Statistics

namespace App\Http\Controllers\Admin\Miscellaneous;

use App\Enums\ChatStatus;
use App\Enums\GiftStatus;
use App\Enums\ProcessType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Role;
use App\Models\Volunteer;
use DB;
use App\Models\Child;
use App\Models\User;
use Analytics;
use Spatie\Analytics\Period;
use App\Models\Faculty;
use App\Models\Blood;

class StatisticController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function child()
    {
        $youngestChild = Child::orderby('birthday', 'DESC')->whereNotNull('birthday')->first();
        $oldestChild = Child::orderby('birthday')->whereYear('birthday', '>', 1950)->first();
        $ageAverage = DB::table('children')->selectRaw('AVG(TIMESTAMPDIFF(YEAR, birthday, CURDATE())) AS `average`')
            ->whereYear('birthday', '>', 1950)
            ->get()[0];
        $childByCity = Child::select('city', DB::raw('count(*) as count'))->groupBy('city')->orderBy('count', 'DESC')
            ->get()->pluck('count', 'city');
        $childByDiagnosis = Child::select('diagnosis', DB::raw('count(*) as count'))->groupBy('diagnosis')
            ->orderBy('count', 'DESC')->get()->pluck('count', 'diagnosis');
        $childByDepartment = Child::select('department', DB::raw('count(*) as count'))->groupBy('department')
            ->orderBy('count', 'DESC')->get()->pluck('count', 'department');
        $childByGift = Child::select('gift_state', DB::raw('count(*) as count'))->groupBy('gift_state')
            ->orderBy('count', 'DESC')->get()->pluck('count', 'gift_state');
        $childByName = Child::select('first_name', DB::raw('count(*) as count'))->groupBy('first_name')
            ->orderBy('count', 'DESC')->limit(20)->get()->pluck('count', 'first_name');

        $mostChats = Child::select('id', 'first_name', 'last_name', 'wish', 'faculty_id')->with('faculty')
            ->withCount('chats')->orderBy('chats_count', 'DESC')->limit(20)->get();

        return view(
            'admin.statistic.child',
            compact(
                'youngestChild',
                'oldestChild',
                'ageAverage',
                'childByCity',
                'childByDiagnosis',
                'childByDepartment',
                'childByGift',
                'childByName',
                'mostChats'
            )
        );
    }

    public function faculty()
    {
        $faculties = Faculty::started()->with('children')->withCount('children')->orderBy('children_count', 'DESC')
            ->get();
        $lastMonths = collect();
        for ($i = 5; $i >= 0; $i--) {
            $lastMonths->push(now()->subMonths($i));
        }

        $faculties = $faculties->map(function ($faculty) use ($lastMonths) {
            $data = [];
            $data['name'] = $faculty->full_name;
            $data['gift_state'] = $faculty->children->groupBy('gift_state')->map->count();
            $data['monthly'] = [];
            foreach ($lastMonths as $month) {
                $count = $faculty->children->filter(function ($child) use ($month) {
                    return $month->format('m.Y') == $child->created_at->format('m.Y');
                })->count();
                $data['monthly'][$month->month] = $count;
            }
            return $data;
        });
        return view('admin.statistic.faculty', compact('faculties', 'lastMonths'));
    }

    public function blood()
    {
        $bloodByCity = Blood::select('city', DB::raw('count(*) as count'))->groupBy('city')->orderBy('count', 'DESC')
            ->get()->pluck('count', 'city');
        $bloodByType = Blood::select('blood_type', DB::raw('count(*) as count'))->groupBy('blood_type')
            ->orderBy('count', 'DESC')
            ->get()->pluck('count', 'blood_type');
        $bloodByRh = Blood::select('rh', DB::raw('count(*) as count'))->groupBy('rh')->orderBy('count', 'DESC')
            ->get()->mapWithKeys(function ($blood) {
                return [$blood->rh_label => $blood->count];
            });
        $bloodByGroup = Blood::select(
            'blood_type',
            'rh',
            DB::raw('CONCAT(blood_type, " ", rh) as blood_group'),
            DB::raw('count(*) as count')
        )->groupBy('blood_group')->orderBy('count', 'DESC')
            ->get()->mapWithKeys(function ($blood) {
                return [
                    ("{$blood->blood_type} {$blood->rh_label}") => $blood->count
                ];
            });
        return view(
            'admin.statistic.blood',
            compact('bloodByType', 'bloodByRh', 'bloodByGroup', 'bloodByCity')
        );
    }

    public function user()
    {
        $youngestUser = User::orderby('birthday', 'DESC')->whereNotNull('birthday')->whereYear('birthday', '<', 2010)
            ->first();
        $oldestUser = User::orderby('birthday')->whereYear('birthday', '>', 1950)->first();
        $ageAverage = DB::table('users')->selectRaw('AVG(TIMESTAMPDIFF(YEAR, birthday, CURDATE())) AS `average`')
            ->whereYear('birthday', '>', 1950)
            ->get()[0];
        $userByName = User::select('first_name', DB::raw('count(*) as count'))->groupBy('first_name')
            ->orderBy('count', 'DESC')->limit(15)->get()->pluck('count', 'first_name');
        $userByHoroscope = $this->getUserHoroscopes();
        $userByFaculty = Faculty::started()->has('users')->withCount('users')->orderBy('users_count', 'DESC')->get()
            ->pluck('users_count', 'name');
        $userByRole = Role::has('users')->withCount('users')->orderBy('users_count', 'DESC')->get()
            ->pluck('users_count', 'display');
        $mostVisits = User::select('id', 'faculty_id', 'first_name', 'last_name')->with('faculty:id,name')
            ->withCount('visits')->orderBy('visits_count', 'DESC')->limit(10)->get();
        $mostChildren = User::select('id', 'faculty_id', 'first_name', 'last_name')->with('faculty:id,name')
            ->withCount('children')->orderBy('children_count', 'DESC')->limit(10)->get();
        $mostAnswers = User::select('id', 'faculty_id', 'first_name', 'last_name')->with('faculty:id,name')
            ->withCount('answers')->orderBy('answers_count', 'DESC')->limit(10)->get();
        $mostApprovals = User::select('id', 'faculty_id', 'first_name', 'last_name')->with('faculty:id,name')
            ->withCount('approvedPosts')->orderBy('approved_posts_count', 'DESC')->limit(10)->get();
        $mostArrivals = User::select('id', 'faculty_id', 'first_name', 'last_name')->with('faculty:id,name')
            ->withCount([
                'processes as arrivals_count' => function ($query) {
                    return $query->type(ProcessType::GiftArrived);
                }
            ])->orderBy('arrivals_count', 'DESC')->limit(10)->get();

        return view(
            'admin.statistic.user',
            compact(
                'youngestUser',
                'oldestUser',
                'ageAverage',
                'userByName',
                'userByHoroscope',
                'userByFaculty',
                'userByRole',
                'mostVisits',
                'mostChildren',
                'mostAnswers',
                'mostApprovals',
                'mostArrivals'
            )
        );
    }

    public function volunteer()
    {
        $facultyAverageTimes = Faculty::started()->has('chats')->with('chats', 'chats.messages')
            ->withCount('children', 'messages')->get()
            ->map(function (
                $faculty
            ) {
                $time = $faculty->chats->avg(function ($chat) {
                    return $chat->averageTime();
                });
                $openChats = $faculty->chats->filter(function ($chat) {
                    return $chat->status == ChatStatus::Open;
                })->count();

                return [
                    'name'             => $faculty->name,
                    'time'             => number_format($time, 2, '.', ''),
                    'open_chats_count' => $openChats,
                    'children_count'   => $faculty->children_count,
                    'messages_count'   => $faculty->messages_count
                ];
            })->sortBy('time');

        $waitingChildren = Child::gift(GiftStatus::Waiting)
            ->with('faculty')
            ->withChatCounts()
            ->whereHas('meetingPost', function ($query) {
                $query->approved();
            })
            ->latest('meeting_day')
            ->get();
        $mostChats = Volunteer::select('id', 'first_name', 'last_name', 'city')
            ->withCount('chats')->orderBy('chats_count', 'DESC')->limit(15)->get();
        $mostChildren = Volunteer::select('id', 'first_name', 'last_name', 'city')
            ->withCount('children')->orderBy('children_count', 'DESC')->limit(15)->get();
        $messageCount = [
            'total' => Message::count(),
            'today' => Message::whereDate('created_at', now()->toDateString())->count()
        ];
        $volunteerCount = [
            'total' => Volunteer::count(),
            'today' => Volunteer::whereDate('created_at', now()->toDateString())->count()
        ];

        $dailyCount = $this->getVolunteerAndMessageDailyCount();

        return view(
            'admin.statistic.volunteer',
            compact(
                'messageCount',
                'volunteerCount',
                'dailyCount',
                'waitingChildren',
                'mostChats',
                'mostChildren',
                'facultyAverageTimes'
            )
        );
    }

    private function getUserHoroscopes()
    {
        $data = collect();
        $users = User::select('id', DB::raw('MONTH(birthday) as month'), DB::raw('DAY(birthday) as day'))->get();
        $horoscopes = [
            'Koç'     => ['start' => ['21', '3'], 'end' => ['19', '4']],
            'Boğa'    => ['start' => ['20', '4'], 'end' => ['20', '5']],
            'İkizler' => ['start' => ['21', '5'], 'end' => ['21', '6']],
            'Yengeç'  => ['start' => ['22', '6'], 'end' => ['22', '7']],
            'Aslan'   => ['start' => ['23', '7'], 'end' => ['22', '8']],
            'Başak'   => ['start' => ['23', '8'], 'end' => ['22', '9']],
            'Terazi'  => ['start' => ['23', '9'], 'end' => ['22', '10']],
            'Akrep'   => ['start' => ['23', '10'], 'end' => ['21', '11']],
            'Yay'     => ['start' => ['22', '11'], 'end' => ['12', '12']],
            'Oğlak'   => ['start' => ['22', '11'], 'end' => ['19', '1']],
            'Kova'    => ['start' => ['20', '1'], 'end' => ['18', '2']],
            'Balık'   => ['start' => ['19', '2'], 'end' => ['20', '3']]
        ];
        foreach ($horoscopes as $horoscope => $dates) {
            $data[$horoscope] = $users->filter(function ($user) use ($dates) {
                return ($user->month == $dates['start'][1] && $user->day >= $dates['start'][0]) || ($user->month == $dates['end'][1] && $user->day <= $dates['end'][0]);
            })->count();
        }
        $data = $data->sort();
        return $data;
    }

    private function getVolunteerAndMessageDailyCount()
    {
        $dailyCount = [];
        $dailyCount['message'] = DB::select('
              SELECT c.datefield AS date, IFNULL(COUNT(m.`id`),0) AS count 
              FROM messages as m 
              RIGHT JOIN calendar as c ON (DATE(m.created_at) = c.datefield) 
              WHERE (c.datefield BETWEEN (CURDATE() - INTERVAL 6 MONTH) AND CURDATE()) 
              GROUP BY DATE');
        $dailyCount['volunteer'] = DB::select('
              SELECT c.datefield AS date, IFNULL(COUNT(v.`id`),0) AS count 
              FROM volunteers as v 
              RIGHT JOIN calendar as c ON (DATE(v.created_at) = c.datefield) 
              WHERE (c.datefield BETWEEN (CURDATE() - INTERVAL 6 MONTH) AND CURDATE()) 
              GROUP BY DATE');

        return $dailyCount;
    }

    public function website(Request $request)
    {
        if ($request->ajax()) {
            $type = $request->type;
            switch ($type) {
                case 'top-referrers':
                    $data = Analytics::fetchTopReferrers(Period::years(1))->mapToGroups(function ($item) {
                        $key = $item['url'];
                        if (str_contains($key, 'facebook')) {
                            $key = 'Facebook';
                        } elseif (str_contains($key, 'instagram')) {
                            $key = 'Instagram';
                        } elseif (str_contains($key, '(direct)')) {
                            $key = 'Direkt';
                        } elseif (str_contains($key, 't.co')) {
                            $key = 'Twitter';
                        } else {
                            $key = title_case($key);
                        }
                        return [$key => $item['pageViews']];
                    })->map->sum();
                    break;
                case 'top-browsers':
                    $data = Analytics::fetchTopBrowsers(Period::years(1));
                    break;
                case 'user-types':
                    $data = Analytics::fetchUserTypes(Period::years(1))->map(function ($item) {
                        $item['type'] = $item['type'] == 'New Visitor'
                            ? 'Yeni Ziyaretçi'
                            : 'Dönen Ziyaretçi';
                        return $item;
                    });
                    break;
                case 'most-visited-pages':
                    $data = Analytics::fetchMostVisitedPages(Period::years(1))->map(function ($item) {
                        $item['pageTitle'] = str_replace('Leyla\'dan Sonra | ', '', $item['pageTitle']);
                        return $item;
                    });
                    break;
                case 'total-visits-pageviews':
                    $data = Analytics::fetchTotalVisitorsAndPageViews(Period::months(2));
                    break;
                case 'today-visits-pageviews':
                    $data = Analytics::fetchTotalVisitorsAndPageViews(Period::days(0));
                    break;
                case 'active-users':
                    $data = Analytics::getAnalyticsService()->data_realtime->get(
                        'ga:' . config('analytics.view_id'),
                        'rt:activeVisitors'
                    )->totalsForAllResults['rt:activeVisitors'];
                    break;
            }
            return api_success($data);
        }
        return view('admin.statistic.website');
    }
}
