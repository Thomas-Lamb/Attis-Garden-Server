<?php

namespace App\Http\Controllers;

use App\Models\Bac;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
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
        $user = $request->user();
        $bacs = $user->bacGetAll();
        return response(['data' => BacResource::collection($bacs)], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $inputs = $request->validate([
            'name' => ['required']
        ]);
        $user = $request->user();
        try {
            $compartiments['1'] = Compartiment::create(['id_plante' => 0, 'id_proprio' => $user->id]);
            $compartiments['2'] = Compartiment::create(['id_plante' => 0, 'id_proprio' => $user->id]);
            $compartiments['3'] = Compartiment::create(['id_plante' => 0, 'id_proprio' => $user->id]);
            $compartiments['4'] = Compartiment::create(['id_plante' => 0, 'id_proprio' => $user->id]);
            $bac = Bac::create([
                'id_proprio' => $user->id,
                'name' => $inputs['name'],
                'id_comp_1' => $compartiments['1']->id,
                'id_comp_2' => $compartiments['2']->id,
                'id_comp_3' => $compartiments['3']->id,
                'id_comp_4' => $compartiments['4']->id,
                'bac_token' => Str::random(20),
            ]);
            $compartiments['1']->update(['id_bac' => $bac->id]);
            $compartiments['2']->update(['id_bac' => $bac->id]);
            $compartiments['3']->update(['id_bac' => $bac->id]);
            $compartiments['4']->update(['id_bac' => $bac->id]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
        return response()->json(['message' => 'Bac created'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param integer $bacNum
     * @param Request $request
     * @return JsonResponse
     */
    public function show(Request $request, int $bacNum): JsonResponse
    {
        $user = $request->user();
        $bac = $user->bacGet($bacNum);
        return response()->json(['data' => new BacResource($bac)], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Bac $bac
     * @return JsonResponse
     */
    public function update(Request $request, $bacNum): JsonResponse
    {
        $inputs = $request->validate([
            'name' => ['required']
        ]);
        $user = $request->user();
        try {
            $response = $user->bacUpdate($bacNum, $inputs);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
        if (!$response) return response()->json(['message' => 'Error bac not found'], 400);
        return response()->json(['message' => 'Bac updated'], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param $bacNum
     * @return JsonResponse
     */
    public function destroy(Request $request, $bacNum): JsonResponse
    {
        $user = $request->user();
        $bac = $user->bacGet($bacNum);
        $compartiments = $bac->compGetAll();
        try {
            foreach ($compartiments as $compartiment) {
                $compartiment->delete();
            }
            $bac->delete();
        } catch(\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
        return response()->json(['message' => 'Bac and compartiments deleted'], 201);
    }
}
