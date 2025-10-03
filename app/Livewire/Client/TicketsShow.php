<?php

namespace App\Livewire\Client;

use Livewire\Component;
use App\Models\Ticket;

class TicketsShow extends Component
{
    public $tickets;

    public function mount()
    {
        $ticketIds = request('ticket_ids');
        
        if ($ticketIds) {
            $ticketIds = explode(',', $ticketIds);
            $this->tickets = Ticket::with(['seance.movie', 'seance.hall', 'seat'])
                ->whereIn('id', $ticketIds)
                ->get();
        } else {
            $this->tickets = collect();
        }
    }

    public function render()
    {
        return view('livewire.client.tickets-show');
    }
}
