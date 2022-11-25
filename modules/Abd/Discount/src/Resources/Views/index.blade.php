@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{route('discounts.index')}}" title="تخفیف ها">تخفیف ها</a></li>
@endsection

@section('content')
    <div class="main-content padding-0 discounts">
        <div class="row no-gutters  ">
            <div class="col-8 margin-left-10 margin-bottom-15 border-radius-3">
                <p class="box__title">تخفیف ها</p>
                <div class="table__box">
                    <div class="table-box">
                        <table class="table">
                            <thead role="rowgroup">
                            <tr role="row" class="title-row">
                                <th>کد تخفیف</th>
                                <th>درصد</th>
                                <th>محدودیت زمانی</th>
                                <th>توضیحات</th>
                                <th>استفاده شده</th>
                                <th>عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($discounts as $discount)
                                <tr role="row" class="">
                                    <td><a href="">{{$discount->code ?? "-"}}</a></td>
                                    <td><a href="">{{$discount->percent}}%</a> برای @lang($discount->type)</td>
                                    <td>{{$discount->expire_at ? createJalalianFromCarbon($discount->expire_at) : "بدون تاریخ انقضاء"}}</td>
                                    <td>{{$discount->description}}</td>
                                    <td>{{number_format($discount->uses)}} نفر</td>
                                    <td>
                                        <a href="" class="item-delete mlg-15"></a>
                                        <a href="edit-discount.html" class="item-edit " title="ویرایش"></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-4 bg-white">
                <p class="box__title">ایجاد تخفیف جدید</p>
                <form action="{{route("discounts.store")}}" method="post" class="padding-30">
                    @csrf
                    <x-input type="text" placeholder="کد تخفیف" name="code"/>
                    <x-input type="number" placeholder="درصد تخفیف" name="percent" required/>
                    <x-input type="number" placeholder="محدودیت افراد" name="usage_limitation"/>
                    <x-input type="text" id="expire_at" placeholder="تاریخ انقضای تخفیف" name="expire_at"/>
                    <p class="box__title">این تخفیف برای</p>
                    <div class="notificationGroup">
                        <input id="discounts-field-1" class="discounts-field-pn" name="type"
                               value="{{\Abd\Discount\Models\Discount::TYPE_ALL}}" type="radio"/>
                        <label for="discounts-field-1">همه دوره ها</label>
                    </div>
                    <div class="notificationGroup">
                        <input id="discounts-field-2" class="discounts-field-pn"
                               name="type" value="{{\Abd\Discount\Models\Discount::TYPE_SPECIAL}}" type="radio"/>
                        <label for="discounts-field-2">دوره خاص</label>
                    </div>
                    <div id="selectCourseContainer" class="d-none">
                        <select name="courses[]" class="mySelect2" multiple>
                            @foreach($courses as $course)
                                <option value="{{$course->id}}">{{$course->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <x-input type="text" name="link" placeholder="لینک اطلاعات بیشتر"/>
                    <x-input type="text" name="description" placeholder="توضیحات" class="margin-bottom-15"/>

                    <button type="submit" class="btn btn-brand">اضافه کردن</button>
                </form>
            </div>
        </div>
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
