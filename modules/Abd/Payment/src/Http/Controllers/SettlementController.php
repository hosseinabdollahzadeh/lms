<?php

namespace Abd\Payment\Http\Controllers;

use Abd\Payment\Http\Requests\SettlementRequest;
use Abd\Payment\Models\Settlement;
use Abd\Payment\Repositories\SettlementRepo;
use Abd\Payment\Services\SettlementService;
use Abd\RolePermissions\Models\Permission;
use App\Http\Controllers\Controller;

class SettlementController extends Controller
{
    public function index(SettlementRepo $repo)
    {
        $this->authorize('index', Settlement::class);
        if (auth()->user()->can(Permission::PERMISSION_MANAGE_SETTLEMENTS)) {
            $settlements = $repo->latest()->paginate();
        } else {
            $settlements = $repo->paginateUserSettlements(auth()->id());
        }
        return view('Payment::settlements.index', compact('settlements'));
    }

    public function create(SettlementRepo $repo)
    {
        $this->authorize('create', Settlement::class);
        if ($repo->getLatestPendingSettlement(auth()->id())) {
            newFeedback("ناموفق", "شما یک درخواست در حال انتظار دارید و فعلا نمی توانید درخواست جدیدی ثبت نمایید.", "error");
            return redirect(route('settlements.index'));
        }
        return view('Payment::settlements.create');
    }

    public function store(SettlementRequest $request, SettlementRepo $repo)
    {
        $this->authorize('create', Settlement::class);
        if ($repo->getLatestPendingSettlement(auth()->id())) {
            newFeedback("ناموفق", "شما یک درخواست در حال انتظار دارید و فعلا نمی توانید درخواست جدیدی ثبت نمایید.", "error");
            return redirect(route('settlements.index'));
        }
        SettlementService::store($request->all());
        return redirect(route('settlements.index'));
    }

    public function edit($settlementId, SettlementRepo $repo)
    {
        $this->authorize('manage', Settlement::class);
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
        $this->authorize('manage', Settlement::class);
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
