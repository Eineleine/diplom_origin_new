<?php

namespace App\Livewire\Client;

use Livewire\Component;
use App\Models\Hall;
use App\Models\Movie;
use Carbon\Carbon;
use Carbon\CarbonPeriod;


class Index extends Component
{
    public $movies;
    public $halls;
    public $week;
    public $chosenDay = 0;

    public function mount()
    {
        $this->halls = Hall::all();
        $this->movies = Movie::all();
        $now = Carbon::now()->locale('ru_RU');
        $period = CarbonPeriod::create($now, 7);
        $this->week = $period->toArray();
    }

    public function render()
    {
        return view('livewire.client.index');
    }
}
