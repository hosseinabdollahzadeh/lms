@extends('User::Front.master')

@section('content')
    <form action="" class="form" method="post">
        <a class="account-logo" href="/">
{{--            <img src="/img/weblogo.png" alt="">--}}
        </a>
        <div class="form-content form-account">
            <input type="text" class="txt-l txt" placeholder="ایمیل">
            <br>
            <button class="btn btn-recoverpass">بازیابی</button>
        </div>
        <div class="form-footer">
            <a href="{{route('loginForm')}}">صفحه ورود</a>
        </div>
    </form>
@endsection
