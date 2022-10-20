<?php

namespace Abd\Payment\Services;

use Abd\Payment\Models\Payment;
use Abd\Payment\Repositories\PaymentRepo;
use Abd\User\Models\User;
use function Termwind\terminal;

class PaymentService
{
    public static function generate($amount, $paymentable, User $buyer)
    {
        if ($amount <= 0 || is_null($paymentable->id) || is_null($buyer->id)) return false;

        $gatway = "";
        $invoiceId = 0;
        if (is_null($paymentable->percent)) {
            $seller_p = $paymentable->percent;
            $seller_share = ($amount * 100) / $seller_p;
            $site_shar = $amount - $seller_share;
        } else {
            $seller_p = $seller_share = $site_shar = 0;
        }
        return resolve(PaymentRepo::class)->store([
            "buyer_id" => $buyer->id,
            "paymentable_id" => $paymentable->id,
            "paymentable_type" => get_class($paymentable),
            "amount" => $amount,
            "invoice_id" => $invoiceId,
            "gateway" => $gatway,
            "status" => Payment::STATUS_PENDING,
            "seller_p" => $seller_p,
            "seller_share" => $seller_share,
            "site_share" => $site_shar,
        ]);
    }
}
