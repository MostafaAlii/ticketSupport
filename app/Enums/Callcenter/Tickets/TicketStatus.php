<?php
namespace App\Enums\Callcenter\Tickets;
enum TicketStatus: string {
    // ['close', '', '', '']
    case CLOSE = 'close';
    case OPEN = 'open';
    case REJECTED = 'rejected';
    case RESOLVED = 'resolved';
}