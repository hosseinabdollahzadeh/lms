@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{route('courses.details', $season->course_id)}}" title="سرفصل ها">سرفصل ها</a></li>
    <li><a href="#" title="ویرایش دوره">ویرایش سرفصل</a></li>
@endsection
@section('content')
    <div class="row no-gutters  ">
        <div class="col-12 bg-white">
            <p class="box__title">به روز رسانی سرفصل</p>
            <form action="{{route('seasons.update', $season->id)}}" class="padding-30" method="post">
                @csrf
                @method('PATCH')
                <x-input name="title" type="text" placeholder="عنوان سرفصل" class="text" value="{{$season->title}}" required/>
                <x-input name="number" type="text" placeholder="شماره سرفصل" class="text" value="{{$season->number}}"/>
                <br>
                <button class="btn btn-brand">به روز رسانی سرفصل</button>
            </form>
        </div>
    </div>
@endsection
