<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wiki extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'id_produit',
        'growing_time',
        'space',
        'optimal_season',
        'description',
        'type',
        'temp_min',
        'temp_max',
        'hydro_min',
        'hydro_max'
    ];
}
