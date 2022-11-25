@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{route('discounts.index')}}" title="تخفیف ها">تخفیف ها</a></li>
@endsection

@section('content')
    <div class="col-4 bg-white">
        <p class="box__title">ویرایش کد تخفیف</p>
        <form action="{{route("discounts.update", $discount->id)}}" method="post" class="padding-30">
            @csrf
            @method('PATCH')
            <x-input type="text" placeholder="کد تخفیف" name="code" value="{{$discount->code}}"/>
            <x-input type="number" placeholder="درصد تخفیف" name="percent" value="{{$discount->percent}}" required/>
            <x-input type="number" placeholder="محدودیت افراد" name="usage_limitation"
                     value="{{$discount->usage_limitation}}"/>
            <x-input type="text" id="expire_at" placeholder="تاریخ انقضای تخفیف" name="expire_at"
                     value="{{$discount->expire_at ? \Morilog\Jalali\Jalalian::fromCarbon($discount->expire_at)->format('Y/m/d H:i'):''}}"/>
            <p class="box__title">این تخفیف برای</p>
            <div class="notificationGroup">
                <input id="discounts-field-1" class="discounts-field-pn" name="type"
                       value="{{\Abd\Discount\Models\Discount::TYPE_ALL}}" type="radio"
                    {{$discount->type == \Abd\Discount\Models\Discount::TYPE_ALL ? "checked": ""}}/>
                <label for="discounts-field-1">همه دوره ها</label>
            </div>
            <div class="notificationGroup">
                <input id="discounts-field-2" class="discounts-field-pn"
                       name="type" value="{{\Abd\Discount\Models\Discount::TYPE_SPECIAL}}" type="radio"
                    {{$discount->type == \Abd\Discount\Models\Discount::TYPE_SPECIAL ? "checked": ""}}/>
                <label for="discounts-field-2">دوره خاص</label>
            </div>
            <div id="selectCourseContainer"
                 class="{{$discount->type == \Abd\Discount\Models\Discount::TYPE_ALL ? "d-none": ""}}">
                <select name="courses[]" class="mySelect2" multiple>
                    @foreach($courses as $course)
                        <option value="{{$course->id}}" {{$discount->courses->contains($course->id) ? "selected" :""}}>
                            {{$course->title}}
                        </option>
                    @endforeach
                </select>
            </div>
            <x-input type="text" name="link" placeholder="لینک اطلاعات بیشتر" value="{{$discount->link}}"/>
            <x-input type="text" name="description" placeholder="توضیحات" class="margin-bottom-15"
                     value="{{$discount->description}}"/>

            <button type="submit" class="btn btn-brand">به روز رسانی</button>
        </form>
    </div>
@endsection

@section('js')
    <script src="/assets/persianDatePicker/js/persianDatepicker.min.js"></script>
    <script src="/js/select2.min.js"></script>
    <script>
        $("#expire_at").persianDatepicker({
            formatDate: "YYYY/MM/DD hh:mm"
        });

        $(document).ready(function () {
            $('.mySelect2').select2({
                placeholder: "یک یا چند دوره را انتخاب کنید..."
            });
        });
    </script>

@endsection

@section('css')
    <link rel="stylesheet" href="/assets/persianDatePicker/css/persianDatepicker-default.css">
    <link href="/css/select2.min.css" rel="stylesheet"/>
@endsection
