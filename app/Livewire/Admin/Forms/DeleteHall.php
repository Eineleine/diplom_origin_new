<?php

namespace App\Livewire\Admin\Forms;

use Livewire\Component;
use App\Models\Hall;
use Illuminate\Support\Facades\DB;

class DeleteHall extends Component
{
    public $active = false;
    public $hall;

    protected $listeners = ['delete-hall' => 'openPopup'];

    public function openPopup($id)
    {
        $this->hall = Hall::findOrFail($id);
        $this->active = true;
    }

    public function closePopup() {
        $this->hall = null;
        $this->active = false;
    }

    public function deleteHall()
    {
        try {
            DB::beginTransaction();
            $this->hall->seats->each->delete();
            $this->hall->seances->each->delete();
            $this->hall->delete();
            DB::commit();
            return redirect(request()->header('Referer'));
        } catch (\Exception $e) {
            DB::rollBack();
            return response($e, 500);
        }
    }
    public function render()
    {
        return view('livewire.admin.forms.delete-hall');
    }
}
