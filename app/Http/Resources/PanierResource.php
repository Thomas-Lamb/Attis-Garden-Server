<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PanierResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "id_produit" => $this->id_produit,
            "quantity" => $this->quantity,
            'name' => $this->name,
            'image' => $this->image,
            "price"=> $this->price,
            "type"=> $this->type,
            'description' => $this->description
        ];
    }
}
