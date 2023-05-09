<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bac;
use App\Models\User;
use App\Models\Compartiment;
use App\Models\AI;
use Illuminate\Http\Request;
use App\Http\Resources\AI as ResourcesAI;

class AIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = User::where('api_token', $request->input('api_token'))->first();
        $compartiments = Compartiment::where('id_proprio', $user->id)
            ->join('wikis', 'compartiments.id_plante', '=', 'wikis.id_produit')
            // ->join('bacs', 'compartiments.id_bac', '=', 'bacs.id')
            ->select('compartiments.*', 'wikis.growing_time', 'wikis.temp_min', 'wikis.temp_max', 'wikis.hydro_min', 'wikis.hydro_max')
            ->get();
        $result = '';
        foreach ($compartiments as $compartiment) {
            $resultLine = ''; $valide = 0;
            if ($compartiment->cap_temp < $compartiment->temp_min) $resultLine = $resultLine . "- Compartiment trop froid de " . ($compartiment->temp_min - $compartiment->cap_temp) . "°C\n";
            else if ($compartiment->cap_temp > $compartiment->temp_max) $resultLine = $resultLine .  "- Compartiment trop chaud de " . ($compartiment->cap_temp - $compartiment->temp_max) . "°C\n";
            else $valide += 1;
            if ($compartiment->cap_hydro < $compartiment->hydro_min) $resultLine = $resultLine . "- Compartiment trop sec de " . ($compartiment->hydro_min - $compartiment->cap_hydro) . "%\n";
            else if ($compartiment->cap_hydro > $compartiment->hydro_max) $resultLine = $resultLine .  "- Compartiment trop humide de " . ($compartiment->cap_hydro - $compartiment->hydro_max) . "%\n";
            else $valide += 1;
            if ($valide != 2) {
                $bac = Bac::where('id', $compartiment->id_bac)->first();
                $resultLine = "Bac: " . $bac->name . " compartiment n°" . ($compartiment->id % 4) .":\n" . $resultLine;
                $result = $result . $resultLine;
                // array_push($result, $resultLine);
            }
        }
        return response($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        AI::create([
            'categorie' => $request->input('categorie'),
            'description' => $request->input('description')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AI  $aI
     * @return \Illuminate\Http\Response
     */
    public function show(AI $aI)
    {
        return $aI;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AI  $aI
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AI $aI)
    {
        $aI->update([
            'categorie' => $request->input('categorie'),
            'description' => $request->input('description')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AI  $aI
     * @return \Illuminate\Http\Response
     */
    public function destroy(AI $aI)
    {
        $aI->delete();
    }
}
