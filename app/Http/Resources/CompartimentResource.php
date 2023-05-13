<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompartimentResource extends JsonResource
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
            'id_plante' => $this->id_plante,
            'date_plantation' => $this->date_plantation,
            'cap_temp' => $this->cap_temp,
            'cap_hydro' => $this->cap_hydro
        ];
    }
}
