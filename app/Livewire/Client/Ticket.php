<?php

namespace App\Livewire\Client;

include(base_path('phpqrcode/qrlib.php'));
use Livewire\Component;
use Illuminate\Support\Str;

class Ticket extends Component
{
    public $tickets = [];

    public function mount()
    {
        if (isset($_GET['tickets'])) {
            foreach ($_GET['tickets'] as $ticket) {
                /* Поиск сведений о билете по коду */
                $ticketObj = \App\Models\Ticket::where('code', $ticket)->first();
                if (is_null($ticketObj)) {
                    App::abort(404);
                }
                $date = Str::match('/SN\d+-R\d+-S\d+-D(\d{4}-\d{2}-\d{2})[a-zA-Z0-9]{16}/', $ticket);
                $this->tickets[] = ['obj' => $ticketObj, 'date' => $date];
            }
        }
    }

    public function getQR($ticket)
    {
        try {
            if (!file_exists("temp/qr/ticket_{$ticket->id}.png")) {
                \QRcode::png($ticket->code, "temp/qr/ticket_{$ticket->id}.png", \QR_ECLEVEL_M, 8, 2);
                
            }
            return "temp/qr/ticket_{$ticket->id}.png";
        } catch (\Exception $e) {
            return response($e, 500);
        }
    }

    public function render()
    {
        return view('livewire.client.ticket');
    }
}
