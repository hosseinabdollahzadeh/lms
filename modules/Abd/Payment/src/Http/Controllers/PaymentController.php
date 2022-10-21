<?php
namespace Abd\Payment\Http\Controllers;


use Abd\Payment\Gateways\Gateway;
use Abd\Payment\Models\Payment;
use Abd\Payment\Repositories\PaymentRepo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function callback(Request $request)
    {
        $gateway = resolve(Gateway::class);
        $paymentRepo = new PaymentRepo();
        $payment = $paymentRepo->findByInvoiceId($gateway->getInvoiceIdFromRequest($request));
        if(!$payment){
            newFeedback("ترکنش ناموفق", "تراکنش مورد نظر یافت نشد !", "error");
            return redirect("/");
        }

        $result = $gateway->verify($payment);

        if(is_array($result)){
            newFeedback("عملیات ناموفق",$result['message'],"error");
            $paymentRepo->changeStatus($payment->id , Payment::STATUS_FAIL);
            // todo relation
//            return redirect()->to($payment->paymentable->path());
            return redirect("/");
        }

        // todo success
        newFeedback("عملیات موفق","پرداخت با موفقیت انجام شد.","success");
        $paymentRepo->changeStatus($payment->id , Payment::STATUS_SUCCESS);
        return redirect("/");

    }
}
