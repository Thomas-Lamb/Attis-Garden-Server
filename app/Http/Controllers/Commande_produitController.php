<?php

namespace App\Http\Controllers;

use App\Models\Commande_produit;
use Illuminate\Http\Request;
use App\Http\Resources\Commande_produitResource;
use App\Http\Controllers\Controller;

class Commande_produitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $commandes = Commande_produit::all();
        return Commande_produitResource::collection($commandes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Commande_produit::create([
            'id_commande' => $request->input('id_commande'),
            'id_produit' => $request->input('id_produit'),
            'quantity' => $request->input('quantity')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function show(Commande_produit $commande_produit)
    {
        return new Commande_produitResource($commande_produit);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Commande_produit $commande_produit)
    {
        $commande_produit::update([
            'id_user' => $request->input('id_user'),
            'traitement' => $request->input('traitement'),
            'pay' => $request->input('pay')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commande_produit $commande_produit)
    {
        $commande_produit->delete();
    }
}
