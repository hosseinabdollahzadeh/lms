<?php

namespace Abd\User\Http\Controllers\Auth;

use Abd\User\Http\Requests\ResetPasswordVerifyCodeRequest;
use Abd\User\Http\Requests\SendResetPasswordVerifyCodeRequest;
use Abd\User\Http\Requests\VerifyCodeRequest;
use Abd\User\Models\User;
use Abd\User\Repositories\UserRepo;
use Abd\User\Services\VerifyCodeService;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

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

    public function showVerifyCodeRequestForm()
    {
        return view('User::Front.passwords.email');
    }

    public function sendVerifyCodeEmail(SendResetPasswordVerifyCodeRequest $request)
    {
        $user = resolve(UserRepo::class)->findByEmail($request->email);

        if($user && ! VerifyCodeService::has($user->id)){
            $user->sendResetPasswordNotification();
        }

        return view('User::Front.passwords.enter-verify-code-form');
    }

    public function checkVerifyCode(ResetPasswordVerifyCodeRequest $request)
    {
        $user = resolve(UserRepo::class)->findByEmail($request->email);

        if($user == null || !VerifyCodeService::check($user->id, $request->verify_code)){
            return back()->withErrors(['verify_code' => 'کد وارد شده معتبر نمی باشد!']);
        }

        auth()->loginUsingId($user->id);
        return redirect()->route('password.showResetForm');
    }
}
