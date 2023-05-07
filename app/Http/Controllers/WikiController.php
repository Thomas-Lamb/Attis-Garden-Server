<?php

namespace App\Http\Controllers;

use App\Models\Wiki;
use App\Models\Produit;
use App\Http\Resources\WikiResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WikiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wikis = Wiki::join('produits', 'wikis.id_produit', '=', 'produits.id')
            ->select('wikis.*','produits.name','produits.image','produits.stock','produits.price', 'produits.description as description_produit', 'produits.type as type_produit')    
            ->get();
        return response()->json(['data' => WikiResource::Collection($wikis), 'state' => 'OK'], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Wiki::create([
            'id_produit' => $request->input('id_produit'),
            'growing_time' => $request->input('growing_time', null),
            'space' => $request->input('space', null),
            'optimal_season' => $request->input('optimal_season', null),
            'description' => $request->input('description'),
            'type' => $request->input('type'),
            'temp_min' => $request->input('temp_min', null),
            'temp_max' => $request->input('temp_max', null),
            'hydro_min' => $request->input('hydro_min', null),
            'hydro_max' => $request->input('hydro_max', null)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Wiki $wiki)
    {
        $data = Wiki::where('wikis.id', $wiki->id)
            ->join('produits', 'wikis.id_produit', '=', 'produits.id')
            ->select('wikis.*','produits.name','produits.image','produits.stock','produits.price', 'produits.description as description_produit', 'produits.type as type_produit')
            ->first();
        return response()->json(['data' => new WikiResource($data), 'state' => 'ok'], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Wiki $wiki)
    {
        $wiki->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wiki $wiki)
    {
        $wiki->delete();
    }
}
