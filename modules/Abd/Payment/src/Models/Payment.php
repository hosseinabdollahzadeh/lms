<?php

namespace Abd\Payment\Models;

use Abd\Discount\Models\Discount;
use Abd\User\Models\User;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $guarded = [];
    const STATUS_PENDING = "pending";
    const STATUS_CANCELLED = "cancelled";
    const STATUS_SUCCESS = "success";
    const STATUS_FAIL = "fail";
    public static $statuses = [
        self::STATUS_PENDING,
        self::STATUS_CANCELLED,
        self::STATUS_SUCCESS,
        self::STATUS_FAIL
    ];

    public function paymentable()
    {
        return $this->morphTo("paymentable");
    }

    public function discounts()
    {
        return $this->belongsToMany(Discount::class, 'discount_payment');
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

}
