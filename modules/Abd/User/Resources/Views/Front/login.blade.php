@extends('User::Front.master')

@section('title', 'صفحه ی ورود')
@section('content')
    <form action="{{route('login')}}" class="form" method="post" style="justify-content: left !important;">
        @csrf
        <a class="account-logo" href="/">
{{--            <img src="/img/weblogo.png" alt="">--}}
        </a>

        <div style="direction: ltr; background-color: #d4edda; border-color: #c3e6cb; width: 100%">
            <b>Demo users</b>
            <hr>
            <i><b>Admin:</b></i><br>
            <pre>admin@test.test<br>admin</pre>
            <i><b>Teacher:</b></i><br>
            <pre>teacher@test.test<br>teacher</pre>
            <i><b>Student:</b></i><br>
            <pre>student@test.test<br>student</pre>
            <br>
        </div>

        <div class="form-content form-account">
            <input id="email" type="text" class="txt-l txt @error('email') is-invalid @enderror"
                   placeholder="ایمیل یا شماره موبایل"
                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

            <input id="password" type="password" class="txt-l txt" placeholder="رمز عبور"
                   name="password" required autocomplete="current-password"
            >
            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

            <br>
            <button class="btn btn--login">ورود</button>
            <label class="ui-checkbox">
                مرا بخاطر داشته باش
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <span class="checkmark"></span>
            </label>
            <div class="recover-password">
                <a href="{{route('password.request')}}">بازیابی رمز عبور</a>
            </div>
        </div>
        <div class="form-footer">
            <a href="{{route('registerForm')}}">صفحه ثبت نام</a>
        </div>
    </form>
@endsection
