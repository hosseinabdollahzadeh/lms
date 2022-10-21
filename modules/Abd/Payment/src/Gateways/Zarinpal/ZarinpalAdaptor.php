<?php

namespace Abd\Payment\Gateways\Zarinpal;

use Abd\Payment\Contracts\GatewayContract;
use Abd\Payment\Models\Payment;

class ZarinpalAdaptor implements GatewayContract
{

    public function request($amount, $description)
    {
        $zp = new zarinpal();
        $callback = "";
        $result = $zp->request("****", $amount, $description, "", "", $callback, true);

        if (isset($result["Status"]) && $result["Status"] == 100) {
            return $result['Authority'];
        } else {
            // error
            echo "خطا در ایجاد تراکنش";
            echo "<br />کد خطا : " . $result["Status"];
            echo "<br />تفسیر و علت خطا : " . $result["Message"];
        }
    }

    public function verify(Payment $payment)
    {
        // TODO: Implement verify() method.
    }
}
