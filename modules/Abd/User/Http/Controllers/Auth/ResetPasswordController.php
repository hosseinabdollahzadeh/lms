<?php

namespace Abd\User\Http\Controllers\Auth;

use Abd\User\Http\Requests\ChangePasswordRequest;
use Abd\User\Rules\ValidPassword;
use Abd\User\Services\UserService;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', new ValidPassword()],
        ];
    }
    public function showResetForm(Request $request)
    {
        $token = $request->route()->parameter('token');

        return view('User::Front.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function reset(ChangePasswordRequest $request)
    {
        UserService::changePassword(auth()->user(), $request->password);
        return redirect()->route('home');
    }
}
