<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Commande_produitResource extends JsonResource
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
            'name' => $this->name,
            'image' => $this->image,
            "quantity"=> $this->quantity,
            "price"=> $this->price,
            "type"=> $this->type,
            'description' => $this->description
        ];
    }
}
