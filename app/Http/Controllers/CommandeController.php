<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Commande_produit;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\CommandeResource;
use App\Http\Controllers\Controller;

class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $commandes = $user->commandeGetAll();
        foreach ($commandes as $commande) {
            $commande_produits = Commande_produit::where("id_commande", $commande->id)->join('produits', 'commande_produits.id_produit', '=', 'produits.id')->get();
            $commande->produits = $commande_produits;
        }
        return response()->json(
            ["data" => CommandeResource::collection($commandes),
            "state" => 'OK'],
            200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $request->user();
        Commande::create([
            'id_user' => $user->id,
            'traitement' => $request->input('traitement', 1),
            'pay' => $request->input('pay', 1)
        ]);
        $commande = Commande::orderByDesc('created_at')->where('id_user', $user->id)->first();
        $produits = $request->input('produits', []);
        foreach ($produits as $produit) {
            Commande_produit::create([
                'id_produit' => $produit["id"],
                'quantity' => $produit["quantity"],
                'id_commande' => $commande->id
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Commande  $commande
     */
    public function show(Commande $commande)
    {
        $commande_produits = Commande_produit::where("id_commande", $commande->id)->join('produits', 'commande_produits.id_produit', '=', 'produits.id')->get();
        $commande->produits = $commande_produits;
        return response()->json(["data" => new CommandeResource($commande),
            "state" => 'OK'],
            200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Commande $commande)
    {
        // Commande::update([
        //     'id_user' => $request->input('id_user'),
        //     'traitement' => $request->input('traitement'),
        //     'pay' => $request->input('pay')
        // ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commande $commande)
    {
        $commande->delete();
    }
}
