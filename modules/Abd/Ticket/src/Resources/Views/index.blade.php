@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{route('tickets.index')}}" title="تیکت ها">تیکت ها</a></li>
@endsection
@section('content')
    <div class="tab__box">
        <div class="tab__items">
            <a class="tab__item is-active" href="{{route("tickets.index")}}">همه تیکت ها</a>
            <a class="tab__item " href="tickets.html">جدید ها (خوانده نشده)</a>
            <a class="tab__item " href="tickets.html">پاسخ داده شده ها</a>
            <a class="tab__item " href="{{route("tickets.create")}}">ارسال تیکت جدید</a>
        </div>
    </div>
    <div class="row no-gutters  ">
        <div class="col-12 margin-left-10 margin-bottom-15 border-radius-3">
            <p class="box__title">تیکت ها</p>
            <div class="table__box">
                <table class="table">
                    <thead role="rowgroup">
                    <tr role="row" class="title-row">
                        <th>شناسه</th>
                        <th>عنوان تیکت</th>
                        <th>نام ارسال کننده</th>
                        <th>ایمیل ارسال کننده</th>
                        <th>آخرین به روز رسانی</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tickets as $ticket)
                        <tr role="row" class="">
                            <td>{{$ticket->id}}</td>
                            <td><a href="{{route('tickets.show', $ticket->id)}}">{{$ticket->title}}</a></td>
                            <td>{{$ticket->user->name}}</td>
                            <td>{{$ticket->user->email}}</td>
                            <td>{{$ticket->updated_at}}</td>
                            <td>{{$ticket->status}}</td>
                            <td>
                                <a href=""
                                   onclick="deleteItem(event, '{{ route('tickets.destroy', $ticket->id)}}');"
                                   class="item-delete mlg-15" title="حذف"></a>
                                <a href="{{ route('tickets.edit', $ticket->id) }}" class="item-edit mlg-15"
                                   title="ویرایش"></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
