<?php

namespace App\Http\Controllers;

use App\Models\Compartiment;
use Illuminate\Http\Request;
use App\Http\Resources\CompartimentResource;

class CompartimentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return response(['data' => CompartimentResource::collection($request['bac']->compGetAll())], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Compartiment  $compartiment
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $compartiment)
    {
        $compartiment = $request['bac']->compGet($compartiment);
        return response()->json(['data' => new CompartimentResource($compartiment)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Compartiment  $compartiment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $compNum)
    {
        $inputs = $request->validate([
            'cap_hydro' => ['integer'],
            'cap_temp' => ['integer'],
            'id_plante' => ['integer']
        ]);
        $bac = $request['bac'];
        $compartiment = $bac->compGet($compNum);
        try {
            $compartiment->update($inputs);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
        return response()->json(['message' => 'Compartiment updated'], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Compartiment  $compartiment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Compartiment $compartiment)
    {
    }
}
