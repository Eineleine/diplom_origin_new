<?php

namespace App\Livewire\Admin\Forms;

use Livewire\Component;
use App\Models\Movie;
use Illuminate\Support\Facades\DB;

class DeleteMovie extends Component
{
    public $active = false;
    public $movie;

    protected $listeners = [
        'delete-movie' => 'openPopup',
    ];

    public function openPopup($id)
    {
        $this->movie = Movie::findOrFail($id);
        $this->active = true;
    }

    public function closePopup()
    {
        $this->movie = null;
        $this->active = false;
    }

    public function deleteMovie()
    {
        try {
            DB::beginTransaction();
            $this->movie->seances->each->delete();
            $this->movie->delete();
            DB::commit();
            return redirect(request()->header('Referer'));
        } catch (\Exception $e) {
            DB::rollBack();
            return response($e, 500);
        }
    }

    public function render()
    {
        return view('livewire.admin.forms.delete-movie');
    }
}
