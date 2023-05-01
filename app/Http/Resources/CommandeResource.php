<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Commande_produitResource;

class CommandeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'id_user' => $this->id_user,
            'traitement' => $this->traitement,
            "pay"=> $this->pay,
            "produits"=> Commande_produitResource::collection($this->produits),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
