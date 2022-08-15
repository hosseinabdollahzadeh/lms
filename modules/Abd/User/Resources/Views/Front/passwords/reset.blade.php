@extends('User::Front.master')

@section('content')
    <form method="POST" action="{{ route('password.update') }}" class="form">
        @csrf
        <a class="account-logo" href="/">
            <img src="/img/weblogo.png" alt="">
        </a>
        <div class="form-content form-account">

            <input id="password" type="password" class="txt txt-l @error('password') is-invalid @enderror"
                   placeholder="رمز عبور جدید *"
                   name="password" required autocomplete="new-passwordAA"
            >
            <input id="password-confirm" type="password" class="txt txt-l @error('password') is-invalid @enderror"
                   placeholder="تأیید رمز عبور جدید *"
                   name="password_confirmation" required autocomplete="new-password"
            >
            <span class="rules">رمز عبور باید حداقل ۶ کاراکتر و ترکیبی از حروف بزرگ، حروف کوچک، اعداد و کاراکترهای غیر الفبا مانند !@#$%^&*() باشد.</span>
            @error('password')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror


            <br>
            <button class="btn continue-btn">به روزرسانی رمز عبور</button>
        </div>

    </form>
@endsection
