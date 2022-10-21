<?php

namespace Abd\Payment\Gateways\Zarinpal;

use Abd\Payment\Contracts\GatewayContract;
use Abd\Payment\Models\Payment;

class ZarinpalAdaptor implements GatewayContract
{
    private $url;
    private $client;

    public function request($amount, $description)
    {
        $this->client = new zarinpal();
        $callback = "http://laravel9-lms.test/test-verify";
        $result = $this->client->request("xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx", $amount, $description, "", "", $callback, true);

        if (isset($result["Status"]) && $result["Status"] == 100) {
            $this->url = $result['StartPay'];
            return $result['Authority'];
        } else {
            return [
                "status" => $result["Status"],
                "message" => $result["Message"]
            ];
        }
    }

    public function verify(Payment $payment)
    {
        // TODO: Implement verify() method.
    }

    public function redirect($invoiceId)
    {
        $this->client->redirect($this->url);
    }

    public function getName()
    {
        return "zarinpal";
    }
}
