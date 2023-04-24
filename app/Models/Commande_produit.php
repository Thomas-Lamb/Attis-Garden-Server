<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande_produit extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_commande',
        'id_produit',
        'quantity'
    ];
}