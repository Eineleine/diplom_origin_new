<?php

namespace App\Livewire\Admin\Forms;

use Livewire\Component;
use App\Models\Hall;
use App\Models\Seat;
use App\Livewire\Admin\OpenSales;
use Illuminate\Support\Facades\DB;

class NewHall extends Component
{
    public $active = false;

    public $title;

    protected $rules = [
        'title' => 'required|string|max:50'
    ];

    protected $messages = [
        'title.max' => 'Название не может быть длиннее 50 символов',
        'title.required' => 'Поле не должно быть пустым'
    ];

    protected $listeners = ['new-hall' => 'openPopup'];

    public function openPopup()
    {
        $this->active = true;
    }

    public function discard()
    {
        $this->reset();
        $this->resetValidation();
        $this->active = false;
    }

    public function save()
    {
        $this->validate();
        try {
            
            DB::beginTransaction();
            $hall = Hall::create([
                'title' => $this->title,
                'rows_count' => 8,
                'seats_count' => 8,
                'price_standart' => 0,
                'price_vip' => 0,
                'active' => false,
            ]);
            for ($i = 1; $i <= 8; $i++) {
                for ($j = 1; $j <= 8; $j++) {
                    Seat::create([
                        'hall_id' => $hall->id,
                        'row' => $i,
                        'seat' => $j,
                        'type' => 'standart',
                    ]);
                }
            }
            DB::commit();
            $this->dispatch('inactive-hall')->to(OpenSales::class);
            return redirect(request()->header('Referer'));
        } catch (\Exception $e) {
            DB::rollback();
            return response($e, 500);
        }
    }

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function render()
    {
        return view('livewire.admin.forms.new-hall');
    }
}
