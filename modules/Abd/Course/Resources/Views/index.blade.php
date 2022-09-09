@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{route('courses.index')}}" title="دوره ها">دوره ها</a></li>
@endsection
@section('content')
    <div class="row no-gutters  ">
        <div class="col-12 margin-left-10 margin-bottom-15 border-radius-3">
            <p class="box__title">دوره ها</p>
            <div class="table__box">
                <table class="table">
                    <thead role="rowgroup">
                    <tr role="row" class="title-row">
                        <th>ردیف</th>
                        <th>شناسه</th>
                        <th>بنر</th>
                        <th>عنوان</th>
                        <th>مدرس</th>
                        <th>قیمت</th>
                        <th>جزئیات</th>
                        <th>درصد مدرس</th>
                        <th>وضعیت</th>
                        <th>وضعیت تأیید</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($courses as $course)
                        <tr role="row" class="">
                            <td>{{$course->priority}}</td>
                            <td>{{$course->id}}</td>
                            <td width="80"><img src="@if(! is_null($course->banner)){{$course->banner->thumb}} @endif" alt="" width="80"/></td>
                            <td>{{$course->title}}</td>
                            <td>{{$course->teacher->name}}</td>
                            <td>{{$course->price}} (تومان)</td>
                            <td><a href="{{route('courses.details', $course->id)}}">مشاهده</a></td>
                            <td>{{$course->percent}}%</td>
                            <td class="status">@lang($course->status)</td>
                            <td class="confirmation_status">@lang($course->confirmation_status)</td>
                            <td>
                                <a href=""
                                   onclick="deleteItem(event, '{{ route('courses.destroy', $course->id)}}');"
                                   class="item-delete mlg-15" title="حذف"></a>
                                <a href="" target="_blank" class="item-eye mlg-15" title="مشاهده"></a>
                                <a href="{{ route('courses.edit', $course->id) }}" class="item-edit mlg-15"
                                   title="ویرایش"></a>
                                <a href="" onclick="updateConfirmationStatus(event, '{{ route('courses.accept', $course->id)}}', 'آیا از تأیید این آیتم اطمینان دارید؟'                                     , 'تأیید شده');" class="item-confirm mlg-15" title="تایید"></a>
                                <a href="" onclick="updateConfirmationStatus(event, '{{ route('courses.reject', $course->id)}}', 'آیا از رد این آیتم اطمینان دارید؟'                                     , 'رد شده');" class="item-reject mlg-15" title="رد"></a>
                                <a href="" onclick="updateConfirmationStatus(event, '{{ route('courses.lock', $course->id)}}', 'آیا از قفل کردن این آیتم اطمینان دارید؟'                                     , 'قفل شده', 'status');" class="item-lock mlg-15" title="قفل دوره"></a>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

