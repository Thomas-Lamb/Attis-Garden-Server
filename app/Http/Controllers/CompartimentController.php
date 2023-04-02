<?php

namespace App\Http\Controllers;

use App\Models\Bac;
use App\Models\User;
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
        if ($request->input("api_token")) {
            $user = User::where('api_token', $request->input('api_token'))->first();
            $compartiments = Compartiment::where('id_proprio', $user->id)->get();
            return response(CompartimentResource::collection($compartiments), 200);
        }
        elseif ($request->input("bac_token")) {
            $bac = Bac::where("bac_token", $request->input("bac_token"))->first();
            $compartiments = Compartiment::where('id_bac', $bac->id)->get();
            return response(CompartimentResource::collection($compartiments), 200);
        }
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
        $user = User::firstWhere('api_token', $request->input('api_token'));
        $compartiments = Compartiment::where('id_proprio', $user->id)->get();
        return new CompartimentResource($compartiments[$compartiment - 1]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Compartiment  $compartiment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $compartiment)
    {
        $bac = Bac::firstWhere('bac_token', $request->input('bac_token'));
        $compartiments = Compartiment::where('id_bac', $bac->id)->get();
        if ($compartiments[$compartiment - 1]->update($request->all())) {
            return response()->json([], 201);
        }
        else {
            return response()->json([], 400);
        }
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
