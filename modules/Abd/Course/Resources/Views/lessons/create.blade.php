@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{route('courses.index')}}" title="دوره ها">دوره ها</a></li>
    <li><a href="{{route('courses.details', $course->id)}}" title="{{$course->title}}">{{$course->title}}</a></li>
    <li><a href="#" title="ایجاد درس">ایجاد درس جدید</a></li>
@endsection
@section('content')
    <div class="row no-gutters  ">
        <div class="col-12 bg-white">
            <p class="box__title">ایجاد درس</p>
            <form action="{{route('lessons.store', $course->id)}}" class="padding-30" method="post" enctype="multipart/form-data">
                @csrf
                <x-input type="text" name="title" placeholder="عنوان درس *" required/>
                <x-input type="text" name="slug" class="text-left " placeholder="نام انگلیسی درس اختیاری"/>
                <x-input type="number" name="time" class="text-left " placeholder="مدت زمان جلسه *" required/>
                <x-input type="number" name="number" class="text-left " placeholder="شماره ی جلسه"/>

                @if(count($seasons))
                    <x-select name="season_id" required>
                        <option value="">انتخاب سرفصل درس *</option>
                        @foreach($seasons as $season)
                            <option value="{{$season->id}}"
                                    @if($season->id == old('season_id')) selected @endif>{{$season->title}}</option>
                        @endforeach
                    </x-select>
                @endif

                <div class="w-50">
                    <p class="box__title">ایا این درس رایگان است ؟ *</p>
                    <div class="notificationGroup">
                        <input id="lesson-upload-field-1" name="is_free" value="0" type="radio" checked="">
                        <label for="lesson-upload-field-1">خیر</label>
                    </div>
                    <div class="notificationGroup">
                        <input id="lesson-upload-field-2" name="is_free" value="1" type="radio">
                        <label for="lesson-upload-field-2">بله</label>
                    </div>
                </div>

                <x-file placeholder="آپلود درس *" name="lesson_file"/>

                <x-textarea name="body" placeholder="توضیحات درس"/>
                <br>
                <button class="btn btn-brand">ایجاد درس</button>
            </form>
        </div>
    </div>
@endsection

