<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seance extends Model
{
    protected $table = 'seances';

    protected $fillable = [
        'movie_id',
        'start',
        'hall_id',
    ];

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public function hall()
    {
        return $this->belongsTo(Hall::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

}
