<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
    public function index()
    {
        $ais = AI::all();
        return ResourcesAI::collection($ais);
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
