<?php

namespace Abd\Payment\Http\Controllers;

use Abd\Payment\Http\Requests\SettlementRequest;
use Abd\Payment\Repositories\SettlementRepo;
use App\Http\Controllers\Controller;

class SettlementController extends Controller
{
    public function index(SettlementRepo $settlementRepo)
    {
        $settlements = $settlementRepo->paginate();
        return view('Payment::settlements.index', compact('settlements'));
    }

    public function create()
    {
        return view('Payment::settlements.create');
    }

    public function store(SettlementRequest $request, SettlementRepo $repo)
    {
        if($repo->store($request->all())){
            auth()->user()->balance -= $request->amount;
            auth()->user()->save();
        }

        newFeedback();

        return redirect(route('settlements.index'));
    }

    public function edit($settlementId, SettlementRepo $repo)
    {
        $settlement = $repo->find($settlementId);
        return view('Payment::settlements.edit', compact('settlement'));
    }

    public function update($settlementId, SettlementRequest $request, SettlementRepo $repo)
    {
        $repo->update($settlementId,$request->all());
        newFeedback();
        return redirect(route('settlements.index'));
    }
}
