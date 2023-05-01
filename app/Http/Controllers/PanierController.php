<?php

namespace App\Http\Controllers;

use App\Models\Panier;
use App\Models\User;
use App\Models\Produit;
use App\Http\Resources\PanierResource;

use Illuminate\Http\Request;

class PanierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = User::where("api_token", $request->input("api_token"))->first();
        $paniers = Panier::where("id_user", $user->id)->join('produits', 'paniers.id_produit', '=', 'produits.id')->get();
        return PanierResource::collection($paniers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = User::where("api_token", $request->input("api_token"))->first();
        Panier::create([
            'id_produit' => $request->input('id_produit'),
            'quantity' => $request->input('quantity'),
            'id_user' => $user->id
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
