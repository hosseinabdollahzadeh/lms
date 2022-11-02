@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{route('settlements.index')}}" title="تسویه حساب ها">تسویه حساب ها</a></li>
@endsection
@section('content')
    <div class="tab__box">
        <div class="tab__items">
            <a class="tab__item is-active" href="{{route('settlements.index')}}"> همه تسویه ها</a>
            <a class="tab__item " href="?status=settled">تسویه های واریز شده</a>
            <a class="tab__item " href="{{route('settlements.create')}}">درخواست تسویه جدید</a>
        </div>
    </div>
    <div class="bg-white padding-20">
        <div class="t-header-search">
            <form action="" onclick="event.preventDefault();">
                <div class="t-header-searchbox font-size-13">
                    <div type="text" class="text search-input__box ">جستجوی دوره</div>
                    <div class="t-header-search-content ">
                        <input type="text" class="text" placeholder="شماره کارت">
                        <input type="text" class="text" placeholder="شماره">
                        <input type="text" class="text" placeholder="تاریخ">
                        <input type="text" class="text" placeholder="ایمیل">
                        <input type="text" class="text margin-bottom-20" placeholder="نام و نام خانوادگی">
                        <btutton class="btn btn-brand">جستجو</btutton>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="table__box">
        <table class="table">
            <thead role="rowgroup">
            <tr role="row" class="title-row">
                <th>شناسه تسویه</th>
                <th>کاربر</th>
                <th>مبدا</th>
                <th>مقصد</th>
                <th>شماره کارت مقصد</th>
                <th>تاریخ درخواست واریز</th>
                <th>تاریخ واریز شده</th>
                <th>مبلغ (تومان )</th>
                <th>وضعیت</th>
                @can(\Abd\RolePermissions\Models\Permission::PERMISSION_MANAGE_SETTLEMENTS)
                <th>عملیات</th>
                @endcan
            </tr>
            </thead>
            <tbody>
            @foreach($settlements as $settlement)
                <tr role="row">
                    <td><a href="">{{$settlement->transaction_id ?? '-'}}</a></td>
                    <td><a href="{{route('users.info',$settlement->user_id)}}">{{$settlement->user->name}}</a></td>
                    <td><a href="">{{$settlement->from ? $settlement->from['name'] : '-'}}</a></td>
                    <td><a href="">{{$settlement->to ? $settlement->to['name'] : '-'}}</a></td>
                    <td><a href="">{{$settlement->to ? $settlement->to['card'] : '-'}}</a></td>
                    <td><a href="">{{$settlement->created_at->diffForHumans()}}</a></td>
                    <td><a href="">{{$settlement->settlet_at ? $settlement->settlet_at->diffForHumans():  "-"}}</a></td>
                    <td><a href="">{{number_format($settlement->amount)}}</a></td>
                    <td><a href="" class="{{$settlement->getStatusCssClass()}}">@lang($settlement->status)</a></td>
                    @can(\Abd\RolePermissions\Models\Permission::PERMISSION_MANAGE_SETTLEMENTS)
                        <td>
                            <a href="{{route('settlements.edit', $settlement->id)}}" class="item-edit "
                               title="ویرایش"></a>
                        </td>
                    @endcan
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
