<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasCompartimentTrait;
use Illuminate\Database\Eloquent\Model;

class Bac extends Model
{
    use HasFactory, HasCompartimentTrait;

    protected $fillable = [
            'id_proprio',
            'name',
            'id_comp_1',
            'id_comp_2',
            'id_comp_3',
            'id_comp_4',
            'bac_token'
    ];
}
