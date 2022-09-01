@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{route('users.index')}}" title="کاربران">کاربران</a></li>
    <li><a href="#" title="ویرایش کاربر">ویرایش کاربر</a></li>
@endsection
@section('content')
    <div class="row no-gutters  ">
        <div class="col-12 bg-white">
            <p class="box__title">به روز رسانی کاربر</p>
            <form action="{{route('users.update', $user->id)}}" class="padding-30" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <x-input type="text" name="name" placeholder="نام کاربر" value="{{$user->name}}" required/>
                <x-input type="text" name="email" class="text-left " placeholder="ایمیل کاربر" value="{{$user->email}}" required />
                <x-input type="text" name="username" class="text-left " placeholder="نام کاربری" value="{{$user->username}}" />
                <x-input type="text" name="mobile" class="text-left " placeholder="موبایل" value="{{$user->mobile}}" />
                <x-input type="text" name="headline" class="text-left " placeholder="عنوان کاربر" value="{{$user->headline}}" />
                <x-input type="text" name="website" class="text-left " placeholder="وب سایت" value="{{$user->website}}" />
                <x-input type="text" name="linkedin" class="text-left " placeholder="لینکدین" value="{{$user->linkedin}}" />
                <x-input type="text" name="facebook" class="text-left " placeholder="فیسبوک" value="{{$user->facebook}}" />
                <x-input type="text" name="twitter" class="text-left " placeholder="توییتر" value="{{$user->twitter}}" />
                <x-input type="text" name="youtube" class="text-left " placeholder="یوتیوب" value="{{$user->youtube}}" />
                <x-input type="text" name="instagram" class="text-left " placeholder="اینستاگرام" value="{{$user->instagram}}" />
                <x-input type="text" name="telegram" class="text-left " placeholder="تلگرام" value="{{$user->telegram}}" />

                <x-select name="status" required>
                    <option value="">وضعیت حساب کاربری</option>
                    @foreach(\Abd\User\Models\User::$statuses as $status)
                        <option value="{{$status}}" @if($status == $user->status) selected @endif>@lang($status)</option>
                    @endforeach
                </x-select>

                <x-file name="image" placeholder="آپلود عکس پروفایل" :value="$user->image" />
                <x-input type="password" name="password" class="text-left " placeholder="پسورد جدید" value="" />
                <x-textarea name="bio" placeholder="بایو" value="{{$user->bio}}"/>
                <br>
                <button class="btn btn-brand">به روز رسانی کاربر</button>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <script>
    @include('Common::layouts.feedbacks')
    </script>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css"/>
@endsection
