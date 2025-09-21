<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Validate;

class HallPrices extends Component
{
    public $halls;
    public $currentHall;
    #[Validate(['prices.*.*' => 'required'])]
    #[Validate(['prices.*.*' => 'integer'])]
    #[Validate(['prices.*.*' => 'min:0'])]
    public $prices = [];

    public function selectHall(int $hallId)
    {
        $this->currentHall = $hallId;
    }

    public function init()
    {
        if ($this->halls->count() > 0) {
            $this->currentHall = $this->halls->first()->id;
            foreach ($this->halls as $hall) {
                $this->prices[$hall->id] = [
                    'standart' => $hall->price_standart,
                    'vip' => $hall->price_vip
                ];
            }
            $this->resetValidation();
        }
    }

    public function save()
    {
        try {
            $this->validate();            
            foreach ($this->halls as $hall) {
                $hall->price_standart = intval($this->prices[$hall->id]['standart']);
                $hall->price_vip = intval($this->prices[$hall->id]['vip']);
                $hall->save();
            }
            $this->js("alert('Цены сохранены.')");
        } catch (\Exception $e) {
            return response($e, 500);
        }
    }

    protected $messages = [
        'prices.*.*.required' => 'Поле не должно быть пустым',
        'prices.*.*.integer' => 'Цена должна быть целым числом',
        'prices.*.*.min' => 'Цена не может быть отрицательной',
    ];

    public function updated($propertyName)
    {
        $this->validate();
    }

    public function mount()
    {
        $this->init();
    }

    public function render()
    {
        return view('livewire.admin.hall-prices');
    }
}
