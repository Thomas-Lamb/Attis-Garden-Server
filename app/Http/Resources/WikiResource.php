<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WikiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'id_produit' => $this->id_produit,
            'name' => $this->name,
            'image' => $this->image,
            "stock"=> $this->stock,
            "price"=> $this->price,
            "type_produit"=> $this->type_produit,
            'description_produit' => $this->description_produit,
            'growing_time' => $this->growing_time,
            'space' => $this->space,
            'optimal_season' => $this->optimal_season,
            'description' => $this->description,
            'type' => $this->type,
            'temp_min' => $this->temp_min,
            'temp_max' => $this->temp_max,
            'hydro_min' => $this->hydro_min,
            'hydro_max' => $this->hydro_max
        ];
    }
}
