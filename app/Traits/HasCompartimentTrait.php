<?php

namespace App\Traits;

use App\Models\Compartiment;

trait HasCompartimentTrait {

    public function compGetAll() {
        $comps = Compartiment::where('id_bac', $this->id)->get();
        return $comps;
    }

    public function compGet($compNum) {
        $comps = Compartiment::where('id_bac', $this->id)->get();
        $comp = $comps[$compNum - 1];
        return $comp;
    }
}