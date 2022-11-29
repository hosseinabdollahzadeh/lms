<?php
namespace Abd\Ticket\Http\Controllers;

use Abd\Media\Services\MediaFileService;
use Abd\Ticket\Http\Requests\TicketRequest;
use Abd\Ticket\Repositories\TicketRepo;
use Abd\Ticket\Services\ReplyService;
use App\Http\Controllers\Controller;

class TicketController extends Controller
{
    public function index(TicketRepo $repo)
    {
        $tickets = $repo->paginateAll();

        return view("Tickets::index", compact('tickets'));
    }

    public function show($ticket, TicketRepo $repo)
    {
        $ticket = $repo->findOrFailWithReplies($ticket);
        return view('Tickets::show', compact('ticket'));
    }

    public function create()
    {
        return view("Tickets::create");
    }

    public function store(TicketRequest $request, TicketRepo $repo)
    {
        $ticket = $repo->store($request->title);
        ReplyService::store($ticket, $request->body, $request->attachment);
        newFeedback();
        return redirect()->route("tickets.index");
    }
}
