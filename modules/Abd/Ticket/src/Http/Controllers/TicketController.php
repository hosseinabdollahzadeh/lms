<?php

namespace Abd\Ticket\Http\Controllers;

use Abd\Common\Responses\AjaxResponses;
use Abd\RolePermissions\Models\Permission;
use Abd\Ticket\Http\Requests\ReplyRequest;
use Abd\Ticket\Http\Requests\TicketRequest;
use Abd\Ticket\Models\Reply;
use Abd\Ticket\Models\Ticket;
use Abd\Ticket\Repositories\TicketRepo;
use Abd\Ticket\Services\ReplyService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(TicketRepo $repo, Request $request)
    {
        if (auth()->user()->can(Permission::PERMISSION_MANAGE_TICKETS)) {
            $tickets = $repo->joinUsers()
                ->searchEmail($request->email)
                ->searchName($request->name)
                ->searchTitle($request->title)
                ->searchDate(dateFromJalali($request->date))
                ->searchStatus($request->status)
                ->paginate();
        }else{
            $tickets = $repo->paginateAll(auth()->id());
        }

        return view("Tickets::index", compact('tickets'));
    }

    public function show($ticket, TicketRepo $repo)
    {
        $ticket = $repo->findOrFailWithReplies($ticket);
        $this->authorize("show", $ticket);
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

    public function reply(Ticket $ticket, ReplyRequest $request)
    {
        $this->authorize("show", $ticket);
        ReplyService::store($ticket, $request->body, $request->attachment);
        newFeedback();
        return redirect()->route("tickets.show", $ticket->id);
    }

    public function close(Ticket $ticket, TicketRepo $repo)
    {
        $this->authorize("show", $ticket);
        $repo->setStatus($ticket->id, Ticket::STATUS_CLOSE);
        newFeedback();
        return redirect()->route("tickets.index");
    }

    public function destroy(Ticket $ticket)
    {
        $this->authorize("delete", $ticket);
        $hasAttachments = Reply::query()->where("ticket_id", $ticket->id)->whereNotNull("media_id")
            ->with("media")->get();
        foreach ($hasAttachments as $reply){
            $reply->media->delete();
        }
        $ticket->delete();
        return AjaxResponses::SuccessResponse();
    }
}
