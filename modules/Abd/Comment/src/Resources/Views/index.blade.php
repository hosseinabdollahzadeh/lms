@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{route('comments.index')}}" title="نظرات">نظرات</a></li>
@endsection
@section('content')
    <div class="tab__box">
        <div class="tab__items">
            <a class="tab__item is-active" href="comments.html"> همه نظرات</a>
            <a class="tab__item " href="comments.html">نظرات تاییده نشده</a>
            <a class="tab__item " href="comments.html">نظرات تاییده شده</a>
        </div>
    </div>
    <div class="bg-white padding-20">
        <div class="t-header-search">
            <form action="" onclick="event.preventDefault();">
                <div class="t-header-searchbox font-size-13">
                    <input type="text" class="text search-input__box font-size-13" placeholder="جستجوی در نظرات">
                    <div class="t-header-search-content ">
                        <input type="text" class="text" placeholder="قسمتی از متن">
                        <input type="text" class="text" placeholder="ایمیل">
                        <input type="text" class="text margin-bottom-20" placeholder="نام و نام خانوادگی">
                        <btutton class="btn btn-brand">جستجو</btutton>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
