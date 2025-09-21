<?php

namespace App\Livewire\Client;

use Livewire\Component;
use Livewire\Attributes\Url;
use App\Models\Seance;
use Carbon\Carbon;

class Hall extends Component
{
    public $seance;
    public $seats = [];
    #[Url]
    public $date = '';

    public function mapSeats()
    {
        foreach ($this->seance->hall->seats as $seat) {
            $this->seats[$seat->row][$seat->seat] = [
                'seat_id' => $seat->id,
                'type' => $seat->type,
                'selected' => false,
            ];
        }

        foreach ($this->seance->tickets as $ticket) {
            $this->seats[$ticket->seat->row][$ticket->seat->seat]['type'] = 'taken';
        }
    }

    public function toggleSelect(int $row, int $seat)
    {
        if (
            $this->seats[$row][$seat]['type'] !== 'disabled'
            && $this->seats[$row][$seat]['type'] !== 'taken'
        ) {
            $this->seats[$row][$seat]['selected'] = !$this->seats[$row][$seat]['selected'];
        } else {
            $this->seats[$row][$seat]['selected'] = false;
        }
    }
    public function confirmBooking()
    {
        $selected = [];
        foreach ($this->seats as $row) {
            foreach ($row as $seat) {
                if ($seat['selected']) {
                    $selected[] = $seat['seat_id'];
                }
            }
        }
        if (count($selected) === 0) {
            $this->js("alert('Вы не выбрали места.')");
        } else {
            $query = http_build_query(['date' => $this->date, 'seance' => $this->seance->id, 'seats' => $selected]);
            redirect('payment?' . $query);
        }
    }

    public function mount($id)
    {
        $this->seance = Seance::findOrFail($id);
        $this->mapSeats();
        if ($this->date === '') {
            $this->date = Carbon::now()->toDateString();
        }
    }

    public function render()
    {
        return view('livewire.client.hall');
    }
}
