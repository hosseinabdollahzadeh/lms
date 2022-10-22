@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{route('payments.index')}}" title="تراکنش ها">تراکنش ها</a></li>
@endsection
@section('content')
    <div class="row no-gutters  ">
        <div class="col-12 margin-left-10 margin-bottom-15 border-radius-3">
            <p class="box__title">تراکنش ها</p>
            <div class="table__box">
                <table class="table">
                    <thead role="rowgroup">
                    <tr role="row" class="title-row">
                        <th>شناسه ی پرداخت</th>
                        <th>نام و نام خانوادگی</th>
                        <th>ایمیل پرداخت کننده</th>
                        <th>مبلغ (تومان)</th>
                        <th>درآمد مدرس</th>
                        <th>درآمد سایت</th>
                        <th>نام دوره</th>
                        <th>تاریخ و ساعت</th>
                        <th>وضعیت</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($payments as $payment)
                        <tr role="row" class="">
                            <td>{{$payment->id}}</td>
                            <td>{{$payment->buyer->name}}</td>
                            <td>{{$payment->buyer->email}}</td>
                            <td>{{$payment->amount}}</td>
                            <td>{{$payment->seller_share}}</td>
                            <td>{{$payment->site_share}}</td>
                            <td>{{$payment->paymentable->title}}</td>
                            <td>{{$payment->created_at}}</td>
                            <td class="@if($payment->status == \Abd\Payment\Models\Payment::STATUS_SUCCESS) text-success @else text-error @endif">@lang($payment->status)</td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
