<?php

namespace Abd\Discount\Listeners;

use function PHPUnit\Framework\isNull;

class UpdateUsedDiscountsForPayment
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        foreach ($event->payment->discounts as $discount){
            $discount->uses++;
            if (!isNull($discount->usage_limitation)){
                $discount->usage_limitation--;
            }
            $discount->save();
        }
    }
}
