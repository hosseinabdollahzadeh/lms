<?php

namespace Abd\Payment\Repositories;


use Abd\Payment\Models\Settlement;

class SettlementRepo
{
    private $query;

    public function __construct()
    {
        $this->query = Settlement::query();
    }

    public function store($request)
    {
        return Settlement::query()->create([
            "user_id" => auth()->id(),
            "to" => [
                "name" => $request["name"],
                "card" => $request["card"],
            ],
            "amount" => $request["amount"],
        ]);
    }

    public function update(int $id, array $request)
    {
        return Settlement::query()->where('id', $id)->update([
            "from" => [
                "name" => $request["from"]["name"],
                "card" => $request["from"]["card"]
            ],
            "to" => [
                "name" => $request["to"]["name"],
                "card" => $request["to"]["card"]
            ],
            "amount" => $request["amount"],
            "status" => $request["status"]
        ]);
    }

    public function paginate()
    {
        return $this->query->paginate();
    }

    public function settled()
    {
        $this->query->where('status', Settlement::STATUS_SETTLED);

        return $this;
    }

    public function find(int $id)
    {
        return Settlement::query()->findOrFail($id);
    }

    public function latest()
    {
        $this->query = $this->query->latest();
        return $this->query;
    }

    public function getLatestPendingSettlement($userId)
    {
        return Settlement::query()
            ->where('user_id', $userId)
            ->where('status',Settlement::STATUS_PENDING)
            ->latest()->first();
    }

    public function getLatestSettlement($userId)
    {
        return Settlement::query()
            ->where('user_id', $userId)
            ->latest()->first();
    }

    public function paginateUserSettlements(int $id)
    {
        return Settlement::query()
            ->where('user_id', $id)
            ->latest()
            ->paginate();
    }
}
