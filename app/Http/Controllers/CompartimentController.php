<?php

namespace App\Http\Controllers;

use App\Models\Compartiment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\CompartimentResource;
use Illuminate\Http\Response;
use Throwable;

class CompartimentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        return response(['data' => CompartimentResource::collection($request['bac']->compGetAll())], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param $compartiment
     * @return JsonResponse
     */
    public function show(Request $request, $compartiment): JsonResponse
    {
        $compartiment = $request['bac']->compGet($compartiment);
        return response()->json(['data' => new CompartimentResource($compartiment)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $compNum
     * @return JsonResponse
     */
    public function update(Request $request, $compNum): JsonResponse
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
        } catch (Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
        return response()->json(['message' => 'Compartiment updated'], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Compartiment $compartiment
     * @return void
     */
    public function destroy(Compartiment $compartiment)
    {
    }
}
