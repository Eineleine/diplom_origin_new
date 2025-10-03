<?php

namespace App\Livewire\Client;

use Livewire\Component;
use Livewire\Attributes\Url;
use App\Models\Seance;
use App\Models\Seat;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Payment extends Component
{
    public $seance;
    public $date;
    public $selectedSeats = [];
    public $seats;
    public $fullPrice = 0;

    public function mount()
    {
        $this->seance = Seance::findOrFail(request('seance'));
        $this->date = request('date');
        $this->selectedSeats = request('seats', []);
        
        $this->loadSeats();
        $this->calculateTotal();
    }

    public function loadSeats()
    {
        $this->seats = Seat::whereIn('id', $this->selectedSeats)->get();
    }

    public function calculateTotal()
    {
        $this->fullPrice = 0;
        foreach ($this->seats as $seat) {
            $price = $seat->type === 'vip' ? $this->seance->hall->price_vip : $this->seance->hall->price_standart;
            $this->fullPrice += $price;
        }
    }

    public function buyTickets()
{
    try {
        $ticketIds = [];
        
        foreach ($this->selectedSeats as $seatId) {
            $ticket = Ticket::create([
                'seance_id' => $this->seance->id,
                'seat_id' => $seatId,
                'seance_date' => $this->date,
                'code' => $this->generateUniqueCode(),
            ]);
            
            $ticketIds[] = $ticket->id;
        }

        return redirect()->route('tickets.show', ['ticket_ids' => implode(',', $ticketIds)]);
        
    } catch (\Illuminate\Database\QueryException $e) {
        if (str_contains($e->getMessage(), 'UNIQUE constraint failed')) {
            $this->js("alert('Некоторые места уже заняты. Пожалуйста, обновите страницу и выберите другие места.')");
            return;
        }
        throw $e;
    }
}

    private function generateUniqueCode()
    {
        do {
            $code = mt_rand(100000, 999999);
        } while (Ticket::where('code', $code)->exists());

        return $code;
    }

    public function render()
    {
        return view('livewire.client.payment');
    }
}
