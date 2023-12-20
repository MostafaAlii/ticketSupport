<?php
namespace App\DataTables\Dashboard\CallCenter;
use App\Models\Ticket;
use App\DataTables\Base\BaseDataTable;
use Yajra\DataTables\EloquentDataTable;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\Utilities\Request as DataTableRequest;
class TicketDataTable extends BaseDataTable {
    protected $query;
    public function __construct(DataTableRequest $request) {
        parent::__construct(new Ticket());
        $this->request = $request;
        $this->query = Ticket::query()->with(['assignedToAdmin', 'assignedToCallCenter', 'callCenter']);
    }

    public function dataTable($query): EloquentDataTable {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (Ticket $ticket) {
                return view('dashboard.call-center.tickets.btn.actions', compact('ticket'));
            })
            ->editColumn('created_at', function (Ticket $ticket) {
                return $this->formatBadge($this->formatDate($ticket->created_at));
            })
            ->editColumn('updated_at', function (Ticket $ticket) {
                return $this->formatBadge($this->formatDate($ticket->updated_at));
            })

            ->editColumn('title', function (Ticket $ticket) {
                return '<a href="'.route('CallCenterTickets.show', $ticket->ticket_code).'">'.$ticket->title.'</a>';
            })
            ->editColumn('status', function (Ticket $ticket) {
                return $this->formatStatus($ticket->status);
            })
            ->editColumn('callcenter_id', function (Ticket $ticket) {
                return $ticket?->callCenter?->name;
            })
        ->rawColumns(['title','action', 'created_at', 'updated_at','status', 'callcenter_id']);
    }

    public function query() {
        return get_user_data()->is_active_manager ? $this->query->latest() : $this->query->whereCallcenterId(get_user_data()->id)->latest();
    }

    public function getColumns(): array {
        return [
            ['name' => 'id', 'data' => 'id', 'title' => '#', 'orderable' => false, 'searchable' => false,],
            ['name' => 'title', 'data' => 'title', 'title' => 'Title',],
            ['name' => 'order_code', 'data' => 'order_code', 'title' => 'Order Code',],
            ['name' => 'ticket_code', 'data' => 'ticket_code', 'title' => 'Ticket Code',],
            ['name' => 'subject', 'data' => 'subject', 'title' => 'Subject',],
            ['name' => 'priority', 'data' => 'priority', 'title' => 'Priority',],
            ['name' => 'callcenter_id', 'data' => 'callcenter_id', 'title' => 'Call Center',],
            ['name' => 'status', 'data' => 'status', 'title' => 'Status',],
            ['name' => 'created_at', 'data' => 'created_at', 'title' => 'Created_at', 'orderable' => false, 'searchable' => false,],
            ['name' => 'updated_at', 'data' => 'updated_at', 'title' => 'Update_at', 'orderable' => false, 'searchable' => false,],
            ['name' => 'action', 'data' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false,],
        ];
    }
}