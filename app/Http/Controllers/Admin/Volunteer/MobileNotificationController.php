<?php
// TODO: Refactor Mobile Notifications

namespace App\Http\Controllers\Admin\Volunteer;

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use PushNotification;
use App\Models\MobileNotification;
use Carbon\Carbon;
use Log;
use App\Models\Subscriber;
use Auth;

class MobileNotificationController extends AdminController
{

    public function index()
    {
        $mobile_notifications = MobileNotification::with('creator')->get();
        return view('admin.mobilenotification.index', compact(['mobile_notifications']));
    }

    public function create()
    {
        return view('admin.mobilenotification.create');
    }

    public function store(Request $request)
    {
        $notification = new MobileNotification();
        $notification->message = $request->message;
        $notification->expected_at = Carbon::createFromFormat('d.m.Y - H:i', $request->expected_at);
        $notification->save();

        return redirect()->route('admin.mobile-notification.index');
    }

    public function send($id, Request $request)
    {
        if (Auth::user()->title != 'Yönetici') {
            return 'Yanlış bir yere geldin herhalde.';
        }
        $notification = MobileNotification::find($id);
        Log::info('Notification #' . $notification->id . ' sending is started.');
        $subscribers = Subscriber::get();
        $counter = 1;
        foreach ($subscribers as $subscriber) {
            PushNotification::app('appNameIOS')
                ->to($subscriber->notification_token)
                ->send($notification->message);
            Log::info($subscriber->id . ' => notification #' . $notification->id . ' sent. ' . $counter . '/' . count($subscribers));
            $counter = $counter + 1;
        }
        Log::info('Notification #' . $notification->id . ' sending is successful.');
        $notification->sent_at = Carbon::now();
        $notification->save();
        return ['Success' => 'Başarıyla gönderildi.'];
    }

    public function destroy($id)
    {
        MobileNotification::destroy($id);
        return 'Success';
    }
}
