@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{route('courses.index')}}" title="دوره ها">دوره ها</a></li>
    <li><a href="#" title="ایجاد درس">ایجاد درس</a></li>
@endsection
@section('content')
    <div class="row no-gutters  ">
        <div class="col-12 bg-white">
            <p class="box__title">به روز رسانی درس</p>
            <form action="{{route('courses.store')}}" class="padding-30" method="post" enctype="multipart/form-data">
                @csrf
                <x-input type="text" name="title" placeholder="عنوان درس" required />
                <x-input type="text" name="slug" class="text-left " placeholder="نام انگلیسی درس اختیاری" required />

                <x-select name="season_id" required>
                    <option value="">انتخاب سرفصل درس</option>
                    @foreach($seasons as $season)
                        <option value="{{$season->id}}" @if($season->id == old('teacher_id')) selected @endif>{{$season->name}}</option>
                    @endforeach
                </x-select>

                <div class="w-50">
                    <p class="box__title">ایا این درس رایگان است ؟ </p>
                    <div class="notificationGroup">
                        <input id="lesson-upload-field-1" name="free" value="0" type="radio" checked="">
                        <label for="lesson-upload-field-1">خیر</label>
                    </div>
                    <div class="notificationGroup">
                        <input id="lesson-upload-field-2" name="free" value="1" type="radio">
                        <label for="lesson-upload-field-2">بله</label>
                    </div>
                </div>

                <x-file placeholder="آپلود درس" name="lesson_file" required />

                <x-textarea name="body" placeholder="توضیحات درس"/>
                <br>
                <button class="btn btn-brand">ایجاد درس</button>
            </form>
        </div>
    </div>
@endsection

