<?php

namespace App\Http\Controllers;

use App\Models\Bac;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Compartiment;
use Illuminate\Http\Request;
use App\Http\Resources\BacResource;

class BacController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = User::where('api_token', $request->input('api_token'))->first();
        $bacs = Bac::where('id_proprio', $user->id)->get();
        return response(new BacResource($bacs), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::where('api_token', $request->input('api_token'))->first();
        Compartiment::create(['id_plante' => 1, 'id_proprio' => $user->id]);
        Compartiment::create(['id_plante' => 1, 'id_proprio' => $user->id]);
        Compartiment::create(['id_plante' => 1, 'id_proprio' => $user->id]);
        Compartiment::create(['id_plante' => 1, 'id_proprio' => $user->id]);
        $compartiments = Compartiment::orderByDesc('created_at')->take(4)->get();
        Bac::create([
            'id_proprio' => $user->id,
            'name' => $request->input('name'),
            'id_comp_1' => $compartiments[0]->id,
            'id_comp_2' => $compartiments[1]->id,
            'id_comp_3' => $compartiments[2]->id,
            'id_comp_4' => $compartiments[3]->id,
            'bac_token' => Str::random(20),
        ]);
        if ($bac = Bac::orderByDesc('created_at')->where('id_proprio', $user->id)->first()) {
            $compartiments[0]->update(['id_bac' => $bac->id]);
            $compartiments[1]->update(['id_bac' => $bac->id]);
            $compartiments[2]->update(['id_bac' => $bac->id]);
            $compartiments[3]->update(['id_bac' => $bac->id]);
            return response()->json([], 201);
        }
        else {
            return response()->json([], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bac  $bac
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $bac)
    {
        $user = User::firstWhere('api_token', $request->input('api_token'));
        $bacs = Bac::where('id_proprio', $user->id)->get();
        return new BacResource($bacs[$bac - 1]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bac  $bac
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $bac)
    {
        $user = User::firstWhere('api_token', $request->input('api_token'));
        $bacs = Bac::where('id_proprio', $user->id)->get();
        if ($bacs[$bac - 1]->update($request->all())) {
            return response()->json([], 201);
        }
        else {
            return response()->json([], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bac  $bac
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $bac)
    {
        $user = User::firstWhere('api_token', $request->input('api_token'));
        $bacs = Bac::where('id_proprio', $user->id)->get();
        $compartiments = Compartiment::where('id_bac', $bacs[$bac - 1]->id);
        if ($bacs[$bac - 1]->delete()) {
            $compartiments[0]->delete();
            $compartiments[1]->delete();
            $compartiments[2]->delete();
            $compartiments[3]->delete();
            return response()->json([], 201);
        }
        else {
            return response()->json([], 400);
        }
    }
}
