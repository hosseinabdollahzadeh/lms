<?php

namespace Abd\Payment\Http\Controllers;


use Abd\Payment\Events\PaymentWasSuccessful;
use Abd\Payment\Gateways\Gateway;
use Abd\Payment\Models\Payment;
use Abd\Payment\Repositories\PaymentRepo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(PaymentRepo $paymentRepo, Request $request)
    {
        $this->authorize('manage', Payment::class);
        $payments = $paymentRepo
            ->searchEmail($request->email)
            ->searchAmount($request->amount)
            ->searchInvoiceId($request->invoice_id)
            ->searchAfterDate(dateFromJalali($request->start_date))
            ->searchBeforeDate(dateFromJalali($request->end_date))
            ->paginate();
        $last30DaysTotal = $paymentRepo->getLastNDaysTotal(-30);
        $last30DaysBenefit = $paymentRepo->getLastNDaysSiteBenefit(-30);
        $last30DaysSellerShare = $paymentRepo->getLastNDaysSellerShare(-30);
        $totalSell = $paymentRepo->getLastNDaysTotal();
        $totalBenefit = $paymentRepo->getLastNDaysSiteBenefit();
        $dates = collect();
        foreach (range(-30, 0) as $i) {
            $dates->put(now()->copy()->addDays($i)->format("Y-m-d"), 0);
        }
        $summery = $paymentRepo->getDailySummery($dates);
        return view('Payment::index', compact(
            'payments',
            'last30DaysTotal',
            'last30DaysBenefit',
            'totalSell',
            'totalBenefit',
            'paymentRepo', 'last30DaysSellerShare', 'dates', 'summery'));
    }

    public function callback(Request $request)
    {
        $gateway = resolve(Gateway::class);
        $paymentRepo = new PaymentRepo();
        $payment = $paymentRepo->findByInvoiceId($gateway->getInvoiceIdFromRequest($request));
        if (!$payment) {
            newFeedback("تراکنش ناموفق", "تراکنش مورد نظر یافت نشد !", "error");
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

    public function purchases()
    {
        $payments = auth()->user()->payments()->with('paymentable')->paginate();

        return view('Payment::purchases', compact('payments'));
    }
}
