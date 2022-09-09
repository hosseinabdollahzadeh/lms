@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{route('users.index')}}" title="کاربران">کاربران</a></li>
    <li><a href="#" title="ویرایش کاربر">ویرایش کاربر</a></li>
@endsection
@section('content')
    <div class="row no-gutters margin-bottom-20  ">
        <div class="col-12 bg-white">
            <p class="box__title">به روز رسانی کاربر</p>
            <form action="{{route('users.update', $user->id)}}" class="padding-30" method="post"
                  enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <x-input type="text" name="name" placeholder="نام کاربر" value="{{$user->name}}" required/>
                <x-input type="text" name="email" class="text-left " placeholder="ایمیل کاربر" value="{{$user->email}}"
                         required/>
                <x-input type="text" name="username" class="text-left " placeholder="نام کاربری"
                         value="{{$user->username}}"/>
                <x-input type="text" name="mobile" class="text-left " placeholder="موبایل" value="{{$user->mobile}}"/>
                <x-input type="text" name="headline" class="text-left " placeholder="عنوان کاربر"
                         value="{{$user->headline}}"/>
                <x-input type="text" name="telegram" class="text-left " placeholder="تلگرام"
                         value="{{$user->telegram}}"/>

                <x-select name="status" required>
                    <option value="">وضعیت حساب کاربری</option>
                    @foreach(\Abd\User\Models\User::$statuses as $status)
                        <option value="{{$status}}"
                                @if($status == $user->status) selected @endif>@lang($status)</option>
                    @endforeach
                </x-select>

                <x-select name="role">
                    <option value="">یک نقش کاربری انتخاب کنید</option>
                    @foreach($roles as $role)
                        <option value="{{$role->name}}" {{$user->hasRole($role->name) ? 'selected' : ''}}>
                            @lang($role->name)
                        </option>
                    @endforeach
                </x-select>

                <x-file name="image" placeholder="آپلود عکس پروفایل" :value="$user->image"/>
                <x-input type="password" name="password" class="text-left " placeholder="پسورد جدید" value=""/>
                <x-textarea name="bio" placeholder="بایو" value="{{$user->bio}}"/>
                <br>
                <button class="btn btn-brand">به روز رسانی کاربر</button>
            </form>
        </div>
    </div>

    <div class="row no-gutters">
        <div class="col-6 margin-left-10 margin-bottom-20">
            <p class="box__title">درحال یادگیری</p>
            <div class="table__box">
                <table class="table">
                    <thead role="rowgroup">
                    <tr role="row" class="title-row">
                        <th>شناسه</th>
                        <th>نام دوره</th>
                        <th>نام مدرس</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr role="row" class="">
                        <td><a href="">1</a></td>
                        <td><a href="">دوره اچ تی ام ال</a></td>
                        <td><a href="">ابوفضل</a></td>
                    </tr>
                    <tr role="row" class="">
                        <td><a href="">1</a></td>
                        <td><a href="">دوره اچ تی ام ال</a></td>
                        <td><a href="">ابوفضل</a></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-6 margin-bottom-20">
            <p class="box__title">دوره های مدرس</p>
            <div class="table__box">
                <table class="table">
                    <thead role="rowgroup">
                    <tr role="row" class="title-row">
                        <th>شناسه</th>
                        <th>نام دوره</th>
                        <th>نام مدرس</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(! is_null($user->courses))
                        @foreach($user->courses as $course)
                            <tr role="row" class="">
                                <td><a href="">{{$course->id}}</a></td>
                                <td><a href="">{{$course->title}}</a></td>
                                <td><a href="">{{$course->teacher->name}}</a></td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="/panel/js/tagsInput.js?v={{uniqid()}}"></script>
@endsection
