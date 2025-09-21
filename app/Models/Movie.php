<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $table = 'movies';

    protected $fillable = [
        'title', // название фильма
        'duration', // длительность в минутах
        'poster', // путь к изображению постера
        'description', // аннотация
        'country', // страна производства
    ];

    public function seances()
    {
        return $this->hasMany(Seance::class);
    }
}
