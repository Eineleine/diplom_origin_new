<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class HallsList extends Component
{
    public $halls;

    public function render()
    {
        return view('livewire.admin.halls-list');
    }
}
