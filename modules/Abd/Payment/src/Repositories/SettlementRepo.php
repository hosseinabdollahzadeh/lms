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

    public function store($data)
    {
        return Settlement::query()->create([
            "user_id" => auth()->id(),
            "to" => [
                "name" => $data["name"],
                "card" => $data["card"],
            ],
            "amount" => $data["amount"]
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
}
