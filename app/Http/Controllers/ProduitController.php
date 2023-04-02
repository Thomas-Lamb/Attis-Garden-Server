<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Produit;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Resources\Produit as ResourcesProduit;

class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produits = Produit::all();
        return ResourcesProduit::collection($produits);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Produit::create([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock'),
            'description' => $request->input('description'),
        ])) {
            return response()->json([], 201);
        }
        else {
            return response()->json([], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Compartiment  $compartiment
     * @return \Illuminate\Http\Response
     */
    public function show($produit)
    {
        $produit = Produit::where('id', $produit)->get();
        return new ResourcesProduit($produit);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Compartiment  $compartiment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $produit)
    {
        $produits = Produit::firstWhere('id', $produit);
        if ($produits->update($request->all())) {
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
    public function destroy(Produit $produit)
    {
        $produit->delete();
    }
}
