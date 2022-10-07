@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{route('courses.index')}}" title="دوره ها">دوره ها</a></li>
    <li><a href="{{route('courses.details', $course->id)}}" title="{{$course->title}}">{{$course->title}}</a></li>
    <li><a href="#" title="ویرایش درس">بروز رسانی درس</a></li>
@endsection
@section('content')
    <div class="row no-gutters  ">
        <div class="col-12 bg-white">
            <p class="box__title">به روز رسانی درس</p>
            <form action="{{route('lessons.update', [$course->id, $lesson->id])}}" class="padding-30" method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <x-input type="text" name="title" placeholder="عنوان درس *" value="{{$lesson->title}}" required/>
                <x-input type="text" name="slug" class="text-left " placeholder="نام انگلیسی درس اختیاری" value="{{$lesson->slug}}"/>
                <x-input type="number" name="time" class="text-left " placeholder="مدت زمان جلسه *" required value="{{$lesson->time}}"/>
                <x-input type="number" name="number" class="text-left " placeholder="شماره ی جلسه" value="{{$lesson->number}}"/>

                @if(count($seasons))
                    <x-select name="season_id" required>
                        <option value="">انتخاب سرفصل درس *</option>
                        @foreach($seasons as $season)
                            <option value="{{$season->id}}"
                                    @if($season->id == $lesson->season_id) selected @endif>{{$season->title}}</option>
                        @endforeach
                    </x-select>
                @endif

                <div class="w-50">
                    <p class="box__title">ایا این درس رایگان است ؟ *</p>
                    <div class="notificationGroup">
                        <input id="lesson-upload-field-1" name="is_free" value="0" type="radio" @if(! $lesson->is_free) checked="" @endif>
                        <label for="lesson-upload-field-1">خیر</label>
                    </div>
                    <div class="notificationGroup">
                        <input id="lesson-upload-field-2" name="is_free" value="1" type="radio" @if($lesson->is_free) checked="" @endif>
                        <label for="lesson-upload-field-2">بله</label>
                    </div>
                </div>

                <x-file placeholder="آپلود درس *" name="lesson_file" :value="$lesson->media"/>

                <x-textarea name="body" placeholder="توضیحات درس" value="{{$lesson->body}}"/>
                <br>
                <button class="btn btn-brand">به روز رسانی درس</button>
            </form>
        </div>
    </div>
@endsection

