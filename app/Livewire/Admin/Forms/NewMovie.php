<?php

namespace App\Livewire\Admin\Forms;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Movie;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewMovie extends Component
{
    use WithFileUploads;

    public $active = false;

    public $title;
    public $description;
    public $duration;
    public $country;
    public $poster;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string|max:500',
        'duration' => 'required|integer|min:10',
        'country' => 'required|string|max:255',
        'poster' => 'required||max:1024|mimes:jpg,png',
    ];

    protected $messages = [
        'poster.required' => 'Необходимо загрузить постер',
        '*.required' => 'Поле не должно быть пустым',
        'title.max' => 'Длина текста не должна превышать 255 символов',
        'country.max' => 'Длина текста не должна превышать 255 символов',
        'description.max' => 'Длина текста не должна превышать 500 символов',
        'duration.min' => 'Значение должно быть не меньше 10',
        '*.integer' => 'Значение должно быть целым числом',
        'poster.mimes' => 'Файл должен быть изображением в формате JPG или PNG',
        'poster.max' => 'Размер файла превышает 1024 кБ',
    ];

    protected $listeners = ['new-movie' => 'openPopup'];

    public function openPopup()
    {
        $this->active = true;
    }

    public function discard()
    {
        $this->reset();
        $this->resetValidation();
        $this->active = false;
    }

    public function save(Request $request)
        {
            $this->validate();
            try {

                $posterName = 'IMG' . date('Y_m_d_H_i_s') . '.' . $this->poster->getClientOriginalExtension();
                $posterPath= $this->poster->storeAs('posters', $posterName, 'public');
        
                DB::beginTransaction();
        
                Movie::create([
                    'title' => $this->title,
                    'description' => $this->description,
                    'duration' => $this->duration,
                    'country' => $this->country,
                    'poster' => $posterPath,
                ]);
        
                DB::commit();
                $this->discard();
                $this->dispatch('update-movies');
                return response(null, 201);
            } catch (\Exception $e) {
                DB::rollback();
                return response($e->getMessage(), 500);
            }
        }

    public function updated($property) {
        $this->validateOnly($property);
    }

    public function render()
    {
        return view('livewire.admin.forms.new-movie');
    }
}
