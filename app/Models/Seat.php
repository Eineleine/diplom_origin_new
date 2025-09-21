<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    protected $table = 'seats';

    protected $fillable = [
        'hall_id', // ID зала
        'row', // номер ряда
        'seat', // номер кресла
        'type' // тип места
    ];

    public function hall()
    {
        return $this->belongsTo(Hall::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
