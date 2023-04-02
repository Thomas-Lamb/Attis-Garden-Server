<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compartiment extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_plante',
        'id_proprio',
        'date_plantation',
        'cap_temp',
        'cap_hydro',
        'id_bac'
    ];
}
