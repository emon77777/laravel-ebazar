<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Models\Frontend\User;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:customer')->except('logout');
    }

    /**
     * Display customer login form
     *
     * @return View
     */
    public function showLoginForm(): View
    {
        return view('frontend.auth.login', ['url' => 'customer']);
    }

    /**
     * Login the customer.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function login(Request $request): RedirectResponse
    {
        $request[$this->username($request)] = $request->username;

        $user = User::query()->where($this->username($request),$request->username)->first();

        $validation = Validator::make($request->all(),[
            $this->username($request) => 'exists:users',
            'password' => ['required',function($attribute,$value,$fail)use($user){
                if(!Hash::check($value,$user->password??'')){
                    $fail('The password is incorrect.');
                }
            }]
        ]);

        if($validation->fails()){
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }

        if(Auth::guard('customer')->attempt($this->credentials($request))){
            //Authentication passed...
            return redirect()
                ->intended('/home')
                ->with('status','You are Logged in as Customer!');
        }

        //Authentication failed...
        return back()->withInput($request->all());
    }

    /**
     * login field of the user
     *
     * @param Request $request
     * @return string
     */
    public function username(Request $request): string
    {
        // this string is column of users table which we are going to use for login
        return filter_var($request->get('username'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    }

    /**
     * Validate the user login request
     *
     * @param Request $request
     */
    private function validator(Request $request)
    {
        //validation rules.
        $rules = [
            $this->username($request) => 'exists:users',
            //'username' => 'required|min:2|max:191',
            'password' => 'required',
        ];

        //custom validation error messages.
        $messages = [
            'exists' => 'The :attribute is not in our records',
        ];

        //validate the request.
        $request->validate($rules,$messages);
    }

    /**
     * An array of user login identifier and password
     *
     * @param Request $request
     * @return array
     */
    private function credentials(Request $request): array
    {
        return [
            $this->username($request) => $request->get('username'),
            'password' => $request->get('password'),
        ];
    }

    /**
     * Redirect back after a failed login.
     *
     * @return RedirectResponse
     */
    private function loginFailed()
    {
        return redirect()
            ->back()
            ->withInput()
            ->with('error','Login failed, please try again!');
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        //Store last login time
        $user = User::query()->findOrFail(auth('customer')->id());
        $user->update(['last_login_datetime'=>now()]);

        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }

}
