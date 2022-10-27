<?php

namespace Abd\Payment\Http\Controllers;


use Abd\Payment\Events\PaymentWasSuccessful;
use Abd\Payment\Gateways\Gateway;
use Abd\Payment\Models\Payment;
use Abd\Payment\Repositories\PaymentRepo;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(PaymentRepo $paymentRepo)
    {
        $this->authorize('manage', Payment::class);
        $payments = $paymentRepo->paginate();
        $last30DaysTotal = $paymentRepo->getLastNDaysTotal(-30);
        $last30DaysBenefit = $paymentRepo->getLastNDaysSiteBenefit(-30);
        $last30DaysSellerShare = $paymentRepo->getLastNDaysSellerShare(-30);
        $totalSell = $paymentRepo->getLastNDaysTotal();
        $totalBenefit = $paymentRepo->getLastNDaysSiteBenefit();
        $last30Days = CarbonPeriod::create(now()->addDays(-30), now());
        return view('Payment::index', compact(
            'payments',
            'last30DaysTotal',
            'last30DaysBenefit',
            'totalSell',
            'totalBenefit',
            'last30Days','paymentRepo', 'last30DaysSellerShare'));
    }

    public function callback(Request $request)
    {
        $gateway = resolve(Gateway::class);
        $paymentRepo = new PaymentRepo();
        $payment = $paymentRepo->findByInvoiceId($gateway->getInvoiceIdFromRequest($request));
        if (!$payment) {
            newFeedback("ترکنش ناموفق", "تراکنش مورد نظر یافت نشد !", "error");
            return redirect("/");
        }

        $result = $gateway->verify($payment);

        if (is_array($result)) {
            newFeedback("عملیات ناموفق", $result['message'], "error");
            $paymentRepo->changeStatus($payment->id, Payment::STATUS_FAIL);
        } else {
            event(new PaymentWasSuccessful($payment));
            newFeedback("عملیات موفق", "پرداخت با موفقیت انجام شد.", "success");
            $paymentRepo->changeStatus($payment->id, Payment::STATUS_SUCCESS);
        }
        return redirect()->to($payment->paymentable->path());
    }
}
