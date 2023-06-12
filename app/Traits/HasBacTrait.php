<?php

namespace App\Traits;

use App\Models\Bac;

trait HasBacTrait {

   public function bacGetAll() {
        $bacs = Bac::where('id_proprio', $this->id)->get();
        return $bacs;
   }

   public function bacGet($bacNum) {
        $bacs = Bac::where('id_proprio', $this->id)->get();
        return $bacs[$bacNum - 1];
   }
}