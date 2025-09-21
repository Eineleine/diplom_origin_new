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
    public $seats;
    public $fullPrice;
    #[Url]
    public $date;

    public function mount()
    {
        if (isset($_GET['seance']) && isset($_GET['seats'])) {
            $this->seance = Seance::findOrFail($_GET['seance']);
            $this->seats = array_map(fn($seat) => Seat::findOrFail($seat), $_GET['seats']);
            $this->fullPrice = array_reduce($this->seats, function ($sum, $seat) {
                return $sum += $seat->type === 'vip'
                    ? $seat->hall->price_vip
                    : $seat->hall->price_standart;
            }, 0);
        }
    }

    public function buyTickets()
    {
        $tickets = [];
        try {
            DB::beginTransaction();
            foreach ($this->seats as $seat) {
                $tickets[] = Ticket::create([
                    'seance_id' => $this->seance->id,
                    'seat_id' => $seat->id,
                    'code' => $this->makeCode($seat)
                ]);
            }
            DB::commit();
            $codes = array_map(fn($ticket) => $ticket->code, $tickets);
            $query = http_build_query(['tickets' => $codes]);
            redirect('ticket?' . $query);
        } catch (\Exception $e) {
            DB::rollBack();
            return response($e, 500);
        }
    }

    protected function makeCode($seat)
    {
        return "SN{$this->seance->id}-R{$seat->row}-S{$seat->seat}-D{$this->date}-" . Str::random(16);
    }

    public function render()
    {
        return view('livewire.client.payment');
    }
}
