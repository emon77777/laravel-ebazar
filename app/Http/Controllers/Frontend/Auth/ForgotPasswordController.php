<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordReset;
use App\Models\Frontend\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Display the form to request a password reset link.
     *
     * @return View
     */
    public function showLinkRequestForm(): View
    {
        return view('frontend.auth.passwords.email');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $this->validate($request,[
          'email' => 'required|exists:users,email'
        ]);

        // Generate password reset verification code and expire date for
        // the verification code. The code and the expiry date will store in
        // database. The verification code won't work after the expiry date.
        $code = random_int(100000,999999);
        $expire = now()->addHour();
        $user = User::query()
            ->where('email',$request->email)
            ->orWhere('mobile',$request->email)
            ->first();
        $user->update(['verification_code'=>$code,'verification_expire_at'=>$expire]);

        $url = url('customer/password/reset');

        $data = [
            'code' => $code,
            'url' => $url
        ];

        Mail::to($request->email)->send(new PasswordReset($data));

        return redirect()->route('customer.password.reset');
    }
}
