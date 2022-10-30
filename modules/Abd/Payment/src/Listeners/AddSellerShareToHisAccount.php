<?php

namespace Abd\Payment\Listeners;

class AddSellerShareToHisAccount
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
        if ($event->payment->seller){
            $event->payment->seller->balance += $event->payment->seller_share;
            $event->payment->seller->save();
        }
    }
}
