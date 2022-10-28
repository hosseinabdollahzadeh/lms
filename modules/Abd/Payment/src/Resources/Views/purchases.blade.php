@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{route('purchases.index')}}" title="خرید های من">خرید های من</a></li>
@endsection
@section('content')
    <div class="table__box">
        <table class="table">
            <thead>
            <tr class="title-row">
                <th><font style="vertical-align: inherit;">عنوان دوره </font></th>
                <th><font style="vertical-align: inherit;">تاریخ پرداخت </font></th>
                <th><font style="vertical-align: inherit;">مقدار پرداختی </font></th>
                <th><font style="vertical-align: inherit;">وضعیت پرداخت </font></th>
            </tr>
            </thead>
            <tbody>
            @foreach($payments as $payment)
                <tr>
                    <td><font style="vertical-align: inherit;"><a href="{{$payment->paymentable->path()}}" target="_blank">{{$payment->paymentable->title}}</a></font></td>
                    <td><font style="vertical-align: inherit;">{{createJalalianFromCarbon($payment->created_at)}}</font></td>
                    <td><font style="vertical-align: inherit;">{{number_format($payment->amount)}} تومان </font></td>
                    <td class="{{ $payment->status == \Abd\Payment\Models\Payment::STATUS_SUCCESS ? "text-success" : "text-error"}}"><font style="vertical-align: inherit;">@lang($payment->status)</font></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$payments->render()}}
    </div>
@endsection
