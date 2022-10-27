@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{route('payments.index')}}" title="تراکنش ها">تراکنش ها</a></li>
@endsection
@section('content')
    <div class="row no-gutters  ">
        <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
            <p>کل فروش ۳۰ روز گذشته سایت </p>
            <p>{{number_format($last30DaysTotal)}} تومان</p>
        </div>
        <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
            <p>درامد خالص ۳۰ روز گذشته سایت</p>
            <p>{{number_format($last30DaysBenefit)}} تومان</p>
        </div>
        <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
            <p>کل فروش سایت</p>
            <p>{{number_format($totalSell)}} تومان</p>
        </div>
        <div class="col-3 padding-20 border-radius-3 bg-white margin-bottom-10">
            <p> کل درآمد خالص سایت</p>
            <p>{{number_format($totalBenefit)}} تومان</p>
        </div>
    </div>
    <div class="row no-gutters border-radius-3 font-size-13">
        <div class="col-12 bg-white padding-30 margin-bottom-20">
            <figure class="highcharts-figure">
                <div id="container"></div>
            </figure>
        </div>
    </div>
    <div class="d-flex flex-space-between item-center flex-wrap padding-30 border-radius-3 bg-white">
        <p class="margin-bottom-15">همه ی تراکنش ها</p>
        <div class="t-header-search">
            <form action="">
                <div class="t-header-searchbox font-size-13">
                    <div type="text" class="text search-input__box ">جستجوی دوره</div>
                    <div class="t-header-search-content ">
                        <input type="text" class="text" name="email" value="{{request("email")}}" placeholder="ایمیل">
                        <input type="text" class="text" name="amount" value="{{request("amount")}}" placeholder="مبلغ به تومان">
                        <input type="text" class="text" name="invoice_id" value="{{request("invoice_id")}}" placeholder="شماره">
                        <input type="text" class="text" name="start_date" value="{{request("start_date")}}" placeholder="از تاریخ : 1399/10/11">
                        <input type="text" class="text margin-bottom-20" name="end_date" value="{{request("end_date")}}" placeholder="تا تاریخ : 1399/10/12">
                        <button type="submit" class="btn btn-brand">جستجو</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-12 margin-left-10 margin-bottom-15 border-radius-3">
        <p class="box__title">تراکنش ها</p>
        <div class="table__box">
            <table class="table">
                <thead role="rowgroup">
                <tr role="row" class="title-row">
                    <th>شناسه ی پرداخت</th>
                    <th>شماره ی تراکنش</th>
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
                        <td>{{$payment->invoice_id}}</td>
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
@endsection

@section('js')
    @include('Common::layouts.feedbacks')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <script>
        Highcharts.chart('container', {
            title: {
                text: 'نممودار فروش 30 روز گذشته',
                align: 'center'
            },
            tooltip: {
                useHTML: true,
                style: {
                    fontSize: "20 px",
                    fontFamily: 'tahoma',
                    direction: "rtl"
                },
                formatter: function () {
                    return (this.x ? "تاریخ: " + this.x + "<br>" : "") + "مبلغ: " + this.y
                }
            },
            xAxis: {
                categories: [@foreach($dates as $date => $value) '{{$date}}', @endforeach]
            },
            yAxis: {
                title: {
                    text: 'مبلغ'
                },
                labels: {
                    formatter: function () {
                        return this.value + " تومان"
                    }
                },
            },
            labels: {
                items: [{
                    html: 'درآمد 30 روز گذشته',
                    style: {
                        left: '50px',
                        top: '18px',
                        color: ( // theme
                            Highcharts.defaultOptions.title.style &&
                            Highcharts.defaultOptions.title.style.color
                        ) || 'black'
                    }
                }]
            },
            series: [{
                type: 'column',
                name: 'تراکنش موفق',
                data: [@foreach($dates as $date => $value) @if($day = $summery->where("date",  $date)->first()) {{ $day->totalAmount }}, @else 0, @endif  @endforeach]
            }, {
                type: 'column',
                name: 'درصد سایت',
                data: [@foreach($dates as $date => $value) @if($day = $summery->where("date",  $date)->first()) {{ $day->totalSiteShare }}, @else 0, @endif  @endforeach]
            }, {
                type: 'column',
                name: 'درصد مدرس',
                data: [@foreach($dates as $date => $value) @if($day = $summery->where("date",  $date)->first()) {{ $day->totalSellerShare}}, @else 0, @endif  @endforeach]
            }, {
                type: 'spline',
                name: 'فروش',
                data: [@foreach($dates as $date => $value) @if($day = $summery->where("date",  $date)->first()) {{ $day->totalAmount }}, @else 0, @endif  @endforeach],
                marker: {
                    lineWidth: 2,
                    lineColor: Highcharts.getOptions().colors[3],
                    fillColor: 'white'
                }
            }, {
                type: 'pie',
                name: 'نسبت',
                data: [{
                    name: 'درصد سایت',
                    y: {{$last30DaysBenefit}},
                    color: Highcharts.getOptions().colors[0] // 2020 color
                }, {
                    name: 'درصد مدرس',
                    y: {{$last30DaysSellerShare}},
                    color: Highcharts.getOptions().colors[1] // 2021 color
                }],
                center: [80, 70],
                size: 100,
                showInLegend: false,
                dataLabels: {
                    enabled: false
                }
            }]
        });

    </script>
@endsection
