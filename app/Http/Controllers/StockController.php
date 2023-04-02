<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use Illuminate\Http\Request;
use App\Http\Resources\Stock as ResourcesStock;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stocks = Stock::all();
        return ResourcesStock::collection($stocks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Stock::create([
            'name' => $request->input('name'),
            'categorie' => $request->input('categorie'),
            'description' => $request->input('description'),
            'stock' => $request->input('stock'),
            'aim_stock' => $request->input('aim_stock'),
            'num_reapro' => $request->input('num_reapro'),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function show(Stock $stock)
    {
        return new ResourcesStock($stock);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stock $stock)
    {
        $stock->update([
            'name' => $request->input('name'),
            'categorie' => $request->input('categorie'),
            'description' => $request->input('description'),
            'stock' => $request->input('stock'),
            'aim_stock' => $request->input('aim_stock'),
            'num_reapro' => $request->input('num_reapro'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stock $stock)
    {
        $stock->delete();
    }
}
