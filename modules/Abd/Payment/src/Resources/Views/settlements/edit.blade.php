@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{route('settlements.index')}}" title="تسویه حساب ها">تسویه حساب ها</a></li>
    <li><a href="#" title="به روز رسانی تسویه حساب">به روز رسانی تسویه حساب</a></li>
@endsection
@section('content')
    <form action="{{route('settlements.update', $settlement->id)}}" method="post" class="padding-30 bg-white font-size-14">
        @csrf
        @method('PATCH')
        <x-input name="from[name]"
                 value='{{is_array($settlement->from) && array_key_exists("name", $settlement->from) ? $settlement->from["name"] : ""}}'
                 placeholder="نام صاحب کارت فرستنده" type="text" />
        <x-input name="from[card]"
                 value='{{is_array($settlement->from) && array_key_exists("card", $settlement->from) ? $settlement->from["card"] : ""}}'
                 placeholder="شماره کارت فرستنده" type="text" />

        <x-input name="to[name]"
                 value='{{is_array($settlement->to) && array_key_exists("name", $settlement->to) ? $settlement->to["name"] : ""}}'
                 placeholder="نام صاحب کارت گیرنده" type="text" required/>
        <x-input name="to[card]"
                 value='{{is_array($settlement->to) && array_key_exists("card", $settlement->to) ? $settlement->to["card"] : ""}}'
                 placeholder="شماره کارت گیرنده" type="text" required/>
        <x-input name="amount" value="{{$settlement->amount}}" readonly placeholder="مبلغ به تومان" type="text" required/>
        <x-select name="status">
            @foreach(\Abd\Payment\Models\Settlement::$statuses as $status)
                <option value="{{$status}}" @if($settlement->status == $status) selected @endif>@lang($status)</option>
            @endforeach
        </x-select>
        <div class="row no-gutters border-2 margin-bottom-15 text-center ">
            <div class="w-50 padding-20 w-50">باقی مانده ی حساب :‌</div>
            <div class="bg-fafafa padding-20 w-50"> {{number_format($settlement->user->balance)}} تومان</div>
        </div>
        <button type="submit" class="btn btn-brand">به روز رسانی</button>
    </form>
@endsection
