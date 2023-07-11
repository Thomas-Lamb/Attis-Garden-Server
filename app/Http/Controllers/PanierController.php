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
        $user = $request->user();
        $paniers = $user->panierGetAll();
        return PanierResource::collection($paniers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = $request->user();
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
