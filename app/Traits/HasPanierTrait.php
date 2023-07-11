<?php


namespace App\Traits;

use App\Models\Panier;

trait HasPanierTrait
{
    public function panierGetAll()
    {
        $paniers = Panier::where('id_user', $this->id)->get();
        return $paniers;
    }
}
