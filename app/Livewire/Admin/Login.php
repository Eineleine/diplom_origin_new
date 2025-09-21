<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public function mount() {
        if (Auth::check()) {
            return redirect()->to('admin');
        }
        
    }
    public function render()
    {
        return view('livewire.admin.login')
            ->layoutData(['admin' => true]);
    }
}
