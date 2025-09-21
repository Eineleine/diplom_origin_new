<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hall extends Model
{
    protected $table = 'halls';

    protected $fillable = [
        'title',
        'rows_count',
        'seats_count',
        'price_standart',
        'price_vip'
    ];

    public function seats()
    {
        return $this->hasMany(Seat::class);
    }

    public function seances()
    {
        return $this->hasMany(Seance::class);
    }
}
