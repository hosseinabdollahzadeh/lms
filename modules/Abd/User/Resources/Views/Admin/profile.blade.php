@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{route('users.index')}}" title="کاربران">کاربران</a></li>
    <li><a href="#" title="ویرایش کاربر">ویرایش پروفایل</a></li>
@endsection
@section('content')
    <div class="row no-gutters margin-bottom-20  ">
        <div class="col-12 bg-white">
            <p class="box__title">به روز رسانی پروفایل</p>
            <x-user-photo />

            <form action="{{route('users.updateProfile', auth()->user()->id)}}" class="padding-30" method="post" >
                @csrf
                <x-input type="text" name="name" placeholder="نام کاربر" value="{{auth()->user()->name}}" required/>
                <x-input type="text" name="email" class="text-left " placeholder="ایمیل کاربر" value="{{auth()->user()->email}}" required/>
                <x-input type="text" name="mobile" class="text-left " placeholder="موبایل" value="{{auth()->user()->mobile}}"/>
                <x-input type="text" name="telegram" class="text-left " placeholder="تلگرام" value="{{auth()->user()->telegram}}"/>
                <x-input type="password" name="password" class="text-left " placeholder="پسورد جدید" value=""/>
                <p class="rules">رمز عبور باید حداقل ۶ کاراکتر و ترکیبی از حروف بزرگ، حروف کوچک، اعداد و کاراکترهای
                    غیر الفبا مانند <strong>!@#$%^&amp;*()</strong> باشد.</p>

                @can(\Abd\RolePermissions\Models\Permission::PERMISSION_TEACH)
                <x-input type="text" name="card_number" class="text-left " placeholder="شماره کارت بانکی" value="{{auth()->user()->card_number}}"/>
                <x-input type="text" name="shaba" class="text-left " placeholder="شماره شبای بانکی" value="{{auth()->user()->shaba}}"/>
                <x-input type="text" name="username" class="text-left " placeholder="نام کاربری و آدرس پروفایل" value="{{auth()->user()->username}}"/>
                <p class="input-help text-left margin-bottom-12" dir="ltr">
                    <a href="{{auth()->user()->profilePath()}}">{{auth()->user()->profilePath()}}</a>
                </p>
                <x-input type="text" name="telegram" class="text-left " placeholder="آیدی شما در تلگرام جهت دریافت نوتیفیکیشن" value="{{auth()->user()->telegram}}"/>
                <x-input type="text" name="headline" class="text-left " placeholder="عنوان کاربر" value="{{auth()->user()->headline}}"/>

                <x-textarea name="bio" placeholder="بایو" value="{!! auth()->user()->bio !!}"/>
                @endcan
                <br>
                <button class="btn btn-brand mt-2">به روز رسانی پروفایل</button>
            </form>
        </div>
    </div>

@endsection

@section('js')
    <script src="/panel/js/tagsInput.js?v={{uniqid()}}"></script>
    <script>
        @include('Common::layouts.feedbacks')
    </script>
@endsection
