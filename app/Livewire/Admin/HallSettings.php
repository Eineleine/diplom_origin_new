<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\Seat;
use Illuminate\Support\Facades\DB;

class HallSettings extends Component
{
    public $halls;
    public $currentHall;
    #[Validate(['rows_count.*' => 'required'])]
    #[Validate(['rows_count.*' => 'integer'])]
    #[Validate(['rows_count.*' => 'min:1'])]
    public $rows_count = [];
    #[Validate(['seats_count.*' => 'required'])]
    #[Validate(['seats_count.*' => 'integer'])]
    #[Validate(['seats_count.*' => 'min:1'])]
    public $seats_count = [];
    public $seats = [];
    public $preventSeatsRender;

    public function init()
    {
        if ($this->halls->count() > 0) {
            $this->currentHall = $this->halls->first()->id;
            foreach ($this->halls as $hall) {
                $this->rows_count[$hall->id] = $hall->rows_count;
                $this->seats_count[$hall->id] = $hall->seats_count;
                foreach ($hall->seats as $seat) {
                    $this->seats[$hall->id][$seat->row][$seat->seat] = $seat->type;
                }
            }
        }
        $this->preventSeatsRender = false;
        $this->resetValidation();
    }

    public function selectHall(int $hallId)
    {
        $this->currentHall = $hallId;
    }

    public function setRows()
    {
        $arrayRowsCount = max(array_keys($this->seats[$this->currentHall]));
        $propRowsCount = $this->rows_count[$this->currentHall];
        if ($arrayRowsCount < $propRowsCount) {
            for ($i = $arrayRowsCount + 1; $i <= $propRowsCount; $i++) {
                for ($j = 1; $j <= $this->seats_count[$this->currentHall]; $j++) {
                    $this->seats[$this->currentHall][$i][$j] = 'standart';
                }
            }
        }
    }

    public function setSeats()
    {
        $arraySeatsCount = max(array_keys($this->seats[$this->currentHall][1]));
        $propSeatsCount = $this->seats_count[$this->currentHall];
        if ($arraySeatsCount < $propSeatsCount) {
            for ($i = 1; $i <= $this->rows_count[$this->currentHall]; $i++) {
                for ($j = $arraySeatsCount + 1; $j <= $propSeatsCount; $j++) {
                    $this->seats[$this->currentHall][$i][$j] = 'standart';
                }
            }
        }
    }

    public function switchSeatType(int $row, int $seat)
    {
        $type = $this->seats[$this->currentHall][$row][$seat];
        $this->seats[$this->currentHall][$row][$seat] = $type === 'standart'
            ? 'vip'
            : ($type === 'vip'
                ? 'disabled'
                : 'standart');
    }

    public function save()
    {
        $this->validate();
        try {
            DB::beginTransaction();
            foreach ($this->halls as $hall) {
                $hall->rows_count = $this->rows_count[$hall->id];
                $hall->seats_count = $this->seats_count[$hall->id];
                $hall->save();
                for ($i = 1; $i <= $hall->rows_count; $i++) {
                    for ($j = 1; $j <= $hall->seats_count; $j++) { {
                            $seat = Seat::updateOrCreate(
                                [
                                    'hall_id' => $hall->id,
                                    'row' => $i,
                                    'seat' => $j
                                ],
                                [
                                    'type' => $this->seats[$hall->id][$i][$j],
                                ]
                            );
                        }
                    }
                Seat::where('hall_id', $hall->id)->where('row', '>', $hall->rows_count)->delete();
                Seat::where('hall_id', $hall->id)->where('seat', '>', $hall->seats_count)->delete();
                }
                DB::commit();
            }
            $this->js("alert('Параметры залов сохранены.')");
        } catch (\Exception $e) {
            DB::rollBack();
            return response($e, 500);
        }
    }

    protected $messages = [
        '*.*.required' => 'Поле не должно быть пустым',
        '*.*.integer' => 'Значение должно быть целым числом',
        '*.*.min' => 'Минимальное значение: 1',
    ];

    public function updated($propertyName)
    {
        $this->preventSeatsRender = true;
        if ($this->validate()) {
            $property = explode('.', $propertyName);
            if ($property[0] === 'rows_count') {
                $this->setRows();
            } else if ($property[0] === 'seats_count') {
                $this->setSeats();
            }
            $this->preventSeatsRender = false;
        }
    }

    public function mount()
    {
        $this->init();
    }

    public function render()
    {
        return view('livewire.admin.hall-settings');
    }
}
