<?php

namespace App\Http\Controllers\Dashboard\CallCenter;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\{Callcenter, ReplyTicket, Ticket};
use App\Services\Dashboard\{CallCenter\TicketService};
use App\DataTables\Dashboard\CallCenter\TicketDataTable;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    public function __construct(protected TicketDataTable $dataTable, protected TicketService $ticketService)
    {
        $this->dataTable = $dataTable;
        $this->ticketService = $ticketService;
    }

    public function index()
    {
        $data = [
            'title' => 'Tickets',
        ];
        return $this->dataTable->render('dashboard.call-center.tickets.index', compact('data'));
    }

    public function store(Request $request)
    {
        try {
            $checkData = Ticket::where('order_code', $request->order_code)->first();
            if (!$checkData) {
                $requestData = $request->all();
                $requestData = array_merge($requestData, ['callcenter_id' => get_user_data()->id]);
                $data = $this->ticketService->create($requestData);
                ReplyTicket::create([
                    'ticket_id' => $data->id,
                    'callcenter_id' => $data->callcenter_id,
                    'status' => 'waiting',
                ]);
                return redirect()->route('CallCenterTickets.index')->with('success', 'Ticket created successfully');

            }
            return redirect()->route('CallCenterTickets.index')->with('error', 'An error occurred while creating the Ticket');

        } catch (\Exception $e) {
            return redirect()->route('CallCenterTickets.index')->with('error', 'An error occurred while creating the Ticket');
        }
    }


    public function show($id)
    {
        $ticket = Ticket::where('ticket_code', $id)->first();
        $data = ReplyTicket::where('ticket_id', $ticket->id)->get();
        dd($data);
    }
}