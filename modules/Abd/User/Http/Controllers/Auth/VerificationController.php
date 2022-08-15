<?php

namespace Abd\User\Http\Controllers\Auth;

use Abd\User\Http\Requests\VerifyCodeRequest;
use Abd\User\Services\VerifyCodeService;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function show(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
            ? redirect($this->redirectPath())
            : view('User::Front.verify');
    }

    public function verify(VerifyCodeRequest $request)
    {
        if(! VerifyCodeService::check(auth()->id(), $request->verify_code)){
            return back()->withErrors(['verify_code' => 'کد وارد شده معتبر نمی باشد!']);
        }
        auth()->user()->markEmailAsVerified();
        return redirect()->route('home');
    }

}
