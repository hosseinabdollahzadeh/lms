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

    public function store(SettlementRequest $request, SettlementRepo $settlementRepo)
    {
        $settlementRepo->store([
            "name" => $request->name,
            "card" => $request->card,
            "amount" => $request->amount,
        ]);

        newFeedback();

        return redirect(route('settlements.index'));
    }
}
