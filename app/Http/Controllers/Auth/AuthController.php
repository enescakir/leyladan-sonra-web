<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;

use App\Http\Requests;
use Auth, Log, Session;
use App\Faculty;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin';
//    protected $loginView = 'admin.auth.login';
//    protected $registerView = 'admin.auth.register';
    protected $redirectAfterLogout = '/admin';


    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Log user in system. It check activation status of user.
     *
     * @param  Request $request -> User login datas
     * @return Return view and status message
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $currentUser = Auth::user();
            $currentUser->last_login = date("Y-m-d H:i:s");
            $currentUser->save();

            if ($currentUser->activated_by == null) {
                Session::flash('flash_message', 'Hesabınız fakülte yöneticiniz tarafından daha onaylanmadı.');
                Auth::logout();
                return back()->withInput($request->only('email', 'remember'));
            } else {
                return redirect()->route('admin.dashboard');
            }
        } else {
            Session::flash('flash_message', 'Giriş bilgilerinizde bir problem var.');
            return back()->withInput($request->only('email', 'remember'));
        }
    }


    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        if (property_exists($this, 'registerView')) {
            return view($this->registerView);
        }
        $faculties = Faculty::all();
        return view('auth.register', compact(['faculties']));
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'faculty_id' => 'required',
            'birthday' => 'required|max:255',
            'mobile' => 'required|max:255',
            'year' => 'required|max:255',
            'title' => 'required|max:255',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'birthday' => $data['birthday'],
            'faculty_id' => intval($data['faculty_id']),
            'mobile' => substr(str_replace(['\0', '+', ')', '(', '-', ' ', '\t'], '', $data['mobile']), -10),
            'year' => $data['year'],
            'title' => $data['title'],
        ]);
    }
}
