@extends('User::Front.master')

@section('content')

    <form method="POST" action="{{ route('password.email') }}" class="form">
        @csrf
        <a class="account-logo" href="/">
            <img src="/img/weblogo.png" alt="">
        </a>
        <div class="form-content form-account">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <input id="email" type="email" class="txt-l txt @error('email') is-invalid @enderror" placeholder="ایمیل"
                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            @error('email')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <br>
            <button type="submit" class="btn btn-recoverpass">بازیابی</button>
        </div>
        <div class="form-footer">
            <a href="login.html">صفحه ورود</a>
        </div>
    </form>

@endsection
