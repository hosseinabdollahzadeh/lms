<?php
namespace Abd\Ticket\Http\Controllers;

use Abd\Media\Services\MediaFileService;
use Abd\Ticket\Http\Requests\TicketRequest;
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

    public function store(TicketRequest $request, TicketRepo $repo)
    {
        $ticket = $repo->store($request->title);
        $media_id = null;
        if ($request->hasFile('attachment')){
            $media_id = MediaFileService::privateUpload($request->attachment)->id;
        }
    }
}
