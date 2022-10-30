<?php

namespace Abd\Dashboard\Http\Controllers;

use Abd\Payment\Repositories\PaymentRepo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function home(PaymentRepo $paymentRepo)
    {
        $totalSales = $paymentRepo->getUserTotalSuccessAmount(auth()->id());
        $totalSiteShare = $paymentRepo->getUserTotalSiteShare(auth()->id());
        $totalBenefit = $paymentRepo->getUserTotalBenefit(auth()->id());
        $todayBenefit= $paymentRepo->getUserTotalBenefitByDay(auth()->id(), now());
        $last30DaysBenefit = $paymentRepo->getUserTotalBenefitByPeriod(auth()->id(), now(), now()->subDays(30));
        $todaySuccessPaymentsCount = $paymentRepo->getUserSellCountByDay(auth()->id(), now());
        $todaySuccessPaymentsTotal = $paymentRepo->getUserTotalSellByDay(auth()->id(), now());

        $payments = $paymentRepo->paymentsBySellerId(auth()->id())->paginate();
        $last30DaysTotal = $paymentRepo->getLastNDaysTotal(-30);
        $last30DaysSellerShare = $paymentRepo->getLastNDaysSellerShare(-30);
        $totalSell = $paymentRepo->getLastNDaysTotal();
        $dates = collect();
        foreach (range(-30, 0) as $i) {
            $dates->put(now()->copy()->addDays($i)->format("Y-m-d"), 0);
        }
        $summery = $paymentRepo->getDailySummery($dates, auth()->id());

        return view('Dashboard::index', compact(
            'totalSales',
            'totalBenefit',
            'totalSiteShare',
            'todayBenefit',
            'last30DaysBenefit',
            'todaySuccessPaymentsTotal',
            'todaySuccessPaymentsCount',
            'last30DaysTotal',
            'last30DaysSellerShare',
            'totalSell',
            'payments',
            'dates',
            'summery'
        ));
    }
}
