<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\AdminPage;
use App\Livewire\Client\Index;
use App\Livewire\Client\Hall;
use App\Livewire\Client\Payment;
use App\Livewire\Client\Ticket;
use App\Livewire\Admin\Login;
use App\Http\Controllers\LoginController;

Route::get('/', Index::class);
Route::get('/seance/{id}', Hall::class);
Route::get('/payment', Payment::class);
Route::get('/ticket', Ticket::class);

Route::get('/admin', AdminPage::class)->middleware('auth');
Route::get('/login', Login::class)->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
