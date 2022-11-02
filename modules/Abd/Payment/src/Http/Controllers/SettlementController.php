<?php

namespace Abd\Payment\Http\Controllers;

use Abd\Payment\Http\Requests\SettlementRequest;
use Abd\Payment\Repositories\SettlementRepo;
use Abd\Payment\Services\SettlementService;
use App\Http\Controllers\Controller;

class SettlementController extends Controller
{
    public function index(SettlementRepo $settlementRepo)
    {
        $settlements = $settlementRepo->latest()->paginate();
        return view('Payment::settlements.index', compact('settlements'));
    }

    public function create(SettlementRepo $repo)
    {
        if ($repo->getLatestPendingSettlement(auth()->id())) {
            newFeedback("ناموفق", "شما یک درخواست در حال انتظار دارید و فعلا نمی توانید درخواست جدیدی ثبت نمایید.", "error");
            return redirect(route('settlements.index'));
        }
        return view('Payment::settlements.create');
    }

    public function store(SettlementRequest $request, SettlementRepo $repo)
    {
        if ($repo->getLatestPendingSettlement(auth()->id())) {
            newFeedback("ناموفق", "شما یک درخواست در حال انتظار دارید و فعلا نمی توانید درخواست جدیدی ثبت نمایید.", "error");
            return redirect(route('settlements.index'));
        }
        SettlementService::store($request->all());
        return redirect(route('settlements.index'));
    }

    public function edit($settlementId, SettlementRepo $repo)
    {
        $requestedSettlement = $repo->find($settlementId);
        $settlement = $repo->getLatestSettlement($requestedSettlement->user_id);
        if ($settlement->id != $settlementId) {
            newFeedback("ناموفق", "این درخواست تسویه قابل ویرایش نیست و بایگانی شده است. فقط آخرین درخواست تسویه ی هر کاربر قابل ویرایش است.", "error");
            return redirect(route('settlements.index'));
        }
        return view('Payment::settlements.edit', compact('settlement'));
    }

    public function update($settlementId, SettlementRequest $request, SettlementRepo $repo)
    {
        $requestedSettlement = $repo->find($settlementId);
        $settlement = $repo->getLatestSettlement($requestedSettlement->user_id);
        if ($settlement->id != $settlementId) {
            newFeedback("ناموفق", "این درخواست تسویه قابل ویرایش نیست و بایگانی شده است. فقط آخرین درخواست تسویه ی هر کاربر قابل ویرایش است.", "error");
            return redirect(route('settlements.index'));
        }
        SettlementService::update($settlementId, $request->all());
        return redirect(route('settlements.index'));
    }
}
