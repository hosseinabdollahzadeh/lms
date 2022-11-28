<?php
namespace Abd\Ticket\Http\Controllers;

use Abd\Ticket\Repositories\TicketRepo;
use App\Http\Controllers\Controller;

class TicketController extends Controller
{
    public function index(TicketRepo $repo)
    {
        $tickets = $repo->paginateAll();

        return view("Tickets::index", compact('tickets'));
    }

    public function create()
    {
        return view("Tickets::create");
    }
}
