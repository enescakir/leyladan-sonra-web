<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/login';
    protected $redirectAfterLogout = '/admin/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated($request, $user)
    {
      //TODO: Check is email and account activated
      // if ($currentUser->activated_at == null) {
      //   $user->last_login = date("Y-m-d H:i:s");
      //   $user->save();
      //
      //     Session::flash('flash_message', 'Hesabınız fakülte yöneticiniz tarafından daha onaylanmadı.');
      //     Auth::logout();
      //     return back()->withInput($request->only('email', 'remember'));
      // } else {
      //     return redirect()->route('admin.dashboard');
      // }
    }

}
