<?php

namespace Abd\Payment\Contracts;

use Abd\Payment\Models\Payment;

interface GatewayContract
{
    public function request($amount, $description);

    public function verify(Payment $payment);

    public function redirect($invoiceId);

    public function getName();
}
