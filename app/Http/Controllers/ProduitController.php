<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Produit;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Resources\ProduitResource;

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
        return response()->json(["data" => ProduitResource::collection($produits), 'state' => 'OK'], 202);
    }

    public function gratuit()
    {
        $produits = Produit::where('price', 0)->get();
        return response()->json(["data" => ProduitResource::collection($produits), 'state' => 'OK'], 202);
    }

    public function payant() {
        $produits = Produit::where('price', '>', 0)->get();
        return response()->json(["data" => ProduitResource::collection($produits), 'state' => 'OK'], 202);
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
            'image' => $request->input('image'),
            'price' => $request->input('price', 0),
            'stock' => $request->input('stock'),
            'type' => $request->input('type'),
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
    public function show(Produit $produit)
    {
        return response()->json(["data" => new ProduitResource($produit), 'state' => 'OK'], 202);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Compartiment  $compartiment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Produit $produit)
    {
        if ($produit->update($request->all())) {
            return response()->json(['state' => 'OK'], 202);
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
