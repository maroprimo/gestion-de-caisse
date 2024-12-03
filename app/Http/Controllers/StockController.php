<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockIngredient;
use App\Models\ProductIngredient;
use App\Models\Ingredient;
use App\Models\UnitIngredient;
use App\Models\SaleItem;
use App\Models\IngredientSupply;

class StockController extends Controller
{
    //
    public function showStock()
    {
        // Récupérer toutes les informations de stock, incluant l'ingrédient associé c'est deux propriété sont définie dans relation
        $stockData = StockIngredient::with('ingredient', 'unitIngredient')->get();

        // Retourner la vue avec les données
        return view('admin.stock', compact('stockData'));
    }

    public function etat(){

        $totalExpense = IngredientSupply::sum('total_amount');

        $totalvente = SaleItem::sum('subtotal');
        $solde = $totalvente - $totalExpense;

        return view('admin.etat', compact('totalExpense', 'totalvente', 'solde'));


    }
}
