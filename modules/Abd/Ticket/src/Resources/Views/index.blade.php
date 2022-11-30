@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{route('tickets.index')}}" title="تیکت ها">تیکت ها</a></li>
@endsection
@section('content')
    <div class="tab__box">
        <div class="tab__items">
            <a class="tab__item {{request()->status == "" ? "is-active": ""}}" href="{{route("tickets.index")}}">
                همه تیکت ها</a>
            @can(\Abd\RolePermissions\Models\Permission::PERMISSION_MANAGE_TICKETS)
                <a class="tab__item {{request()->status == \Abd\Ticket\Models\Ticket::STATUS_OPEN ? "is-active": ""}}"
                   href="?{{request()->getQueryString()}}&status={{\Abd\Ticket\Models\Ticket::STATUS_OPEN}}">
                    جدید ها (خوانده نشده)</a>
                <a class="tab__item {{request()->status == \Abd\Ticket\Models\Ticket::STATUS_REPLIED ? "is-active": ""}}"
                   href="?{{request()->getQueryString()}}&status={{\Abd\Ticket\Models\Ticket::STATUS_REPLIED}}">
                    پاسخ داده شده ها</a>
                <a class="tab__item {{request()->status == \Abd\Ticket\Models\Ticket::STATUS_CLOSE ? "is-active": ""}}"
                   href="?{{request()->getQueryString()}}&status={{\Abd\Ticket\Models\Ticket::STATUS_CLOSE}}">
                    بسته شده ها</a>
                <a class="tab__item {{request()->status == \Abd\Ticket\Models\Ticket::STATUS_PENDING ? "is-active": ""}}"
                   href="?{{request()->getQueryString()}}&status={{\Abd\Ticket\Models\Ticket::STATUS_PENDING}}">
                    در حال بررسی ها</a>
            @endcan
            <a class="tab__item " href="{{route("tickets.create")}}">ارسال تیکت جدید</a>
        </div>
    </div>
    @can(\Abd\RolePermissions\Models\Permission::PERMISSION_MANAGE_TICKETS)
        <div class="bg-white padding-20">
            <div class="t-header-search">
                <form action="{{route("tickets.index")}}">
                    <div class="t-header-searchbox font-size-13">
                        <input type="text" class="text search-input__box font-size-13" name="title"
                               value="{{request()->title}}" placeholder="جستجو در تیکت ها"/>
                        <div class="t-header-search-content ">
                            <input type="text" class="text" name="email" value="{{request()->email}}"
                                   placeholder="ایمیل">
                            <input type="text" class="text" name="name" value="{{request()->name}}"
                                   placeholder="نام و نام خانوادگی">
                            <input type="text" class="text margin-bottom-20" name="date" value="{{request()->date}}"
                                   placeholder="تاریخ">
                            <button class="btn btn-brand" type="submit">جستجو</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endcan
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
                            <td>{{\Morilog\Jalali\Jalalian::fromCarbon($ticket->updated_at)}}</td>
                            <td>@lang($ticket->status)</td>
                            <td>
                                <a href="{{route("tickets.close", $ticket->id)}}">بستن تیکت</a>
                                @can(\Abd\RolePermissions\Models\Permission::PERMISSION_MANAGE_TICKETS)
                                    <a href=""
                                       onclick="deleteItem(event, '{{ route('tickets.destroy', $ticket->id)}}');"
                                       class="item-delete mlg-15" title="حذف"></a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
