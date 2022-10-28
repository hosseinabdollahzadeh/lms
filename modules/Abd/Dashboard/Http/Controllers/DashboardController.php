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
        return view('Dashboard::index', compact(
            'totalSales',
            'totalBenefit',
            'totalSiteShare',
            'todayBenefit',
            'last30DaysBenefit',
            'todaySuccessPaymentsTotal',
            'todaySuccessPaymentsCount'));
    }
}
