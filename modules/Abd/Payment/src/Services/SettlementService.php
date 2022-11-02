<?php

namespace Abd\Payment\Services;

use Abd\Payment\Models\Settlement;
use Abd\Payment\Repositories\SettlementRepo;

class SettlementService
{
    public static function store(array $data)
    {
        $repo = new SettlementRepo();
        if ($repo->store($data)) {
            auth()->user()->balance -= $data["amount"];
            auth()->user()->save();
        }

        newFeedback();
    }

    public static function update(int $settlementId, array $data)
    {
        $repo = new SettlementRepo();
        $settlement = $repo->find($settlementId);
        if (!in_array($settlement->status, [Settlement::STATUS_CANCELLED, Settlement::STATUS_REJECTED]) &&
            in_array($data["status"], [Settlement::STATUS_CANCELLED, Settlement::STATUS_REJECTED])) {
            $settlement->user->balance += $settlement->amount;
            $settlement->user->save();
        }

        if (in_array($settlement->status, [Settlement::STATUS_CANCELLED, Settlement::STATUS_REJECTED]) &&
            in_array($data["status"], [Settlement::STATUS_SETTLED, Settlement::STATUS_PENDING])) {
            if ($settlement->user->balance < $data['amount']) {
                newFeedback("ناموفق", "موجودی حساب کاربر، کافی نمی باشد.", "error");
                return;
            }
            $settlement->user->balance -= $settlement->amount;
            $settlement->user->save();
        }
        $repo->update($settlementId, $data);
        newFeedback();
    }
}
