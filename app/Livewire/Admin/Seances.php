<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Movie;
use App\Models\Seance;
use Illuminate\Support\Facades\DB;

class Seances extends Component
{

    public $halls;
    public $movies;

    protected $listeners = [
        'update-movies' => 'updateMovies',
        'seances-collected' => 'save'
    ];

    public function save($data)
    {
        try {
            DB::beginTransaction();
            Seance::truncate();
            foreach ($data as $item) {
                Seance::Create([
                    'hall_id' => intval($item['hall_id']),
                    'movie_id' => intval($item['movie_id']),
                    'start' => $item['start']
                ]);
            }
            DB::commit();
            $this->js("alert('Сеансы сохранены.')");
        } catch (\Exception $e) {
            DB::rollBack();
            return response($e, 500);
        }
    }

    public function updateMovies()
    {
        $this->movies = Movie::all();
    }

    public function mount()
    {
        $this->updateMovies();
    }

    public function render()
    {
        return view('livewire.admin.seances');
    }
}
