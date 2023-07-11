<?php


namespace App\Traits;

use App\Models\Commande;
use App\Models\Commande_produit;

trait HasCommandesTrait
{

    public function commandeGetAll()
    {
        $commandes = Commande::where('id_user', $this->id)->get();
        return $commandes;
    }

    public function commandeGet($commandeNum)
    {
        $commande = Commande::where('id_user', $this->id)->find();
        if (!is_null($commande)) {
            if ($commande->id_user != $this->id) {
                return $commande;
            }
        }
    }

    public function commandeUpdate($bacNum, $inputs): bool
    {
        $bacs = Bac::where('id_proprio', $this->id)->get();
        if (count($bacs) < $bacNum) {
            return false;
        } else {
            $bacs[$bacNum - 1]->update($inputs);
            return true;
        }
    }
}
