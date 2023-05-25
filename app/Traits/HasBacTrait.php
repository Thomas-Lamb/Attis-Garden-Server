<?php

namespace App\Traits;

use App\Models\Bac;

trait HasBacTrait {

     public function bacGetAll() {
          $bacs = Bac::where('id_proprio', $this->id)->get();
          foreach ($bacs as $bac) {
               $bac->compartiments = $bac->compGetAll();
          }
          return $bacs;
     }

     public function bacGet($bacNum) {
          $bacs = Bac::where('id_proprio', $this->id)->get();
          foreach ($bacs as $bac) {
               $bac->compartiments = $bac->compGetAll();
          }
          return $bacs[$bacNum - 1];
     }

     public function bacUpdate($bacNum, $inputs) : bool {
         $bacs = Bac::where('id_proprio', $this->id)->get();
         if (count($bacs) < $bacNum) {
             return false;
         }
         else {
             $bacs[$bacNum - 1]->update($inputs);
             return true;
         }
     }
}
