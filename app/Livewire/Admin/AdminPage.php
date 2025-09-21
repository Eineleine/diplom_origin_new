<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Hall;

class AdminPage extends Component
{
    public $halls;

    public function mount() {
        $this->halls = Hall::all();
    }

    public function render()
    {
        return view('livewire.admin.admin-page')
            ->layoutData(['admin' => true]);
    }
}
