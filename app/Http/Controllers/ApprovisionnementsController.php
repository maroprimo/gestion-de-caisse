<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredient;
use App\Models\Supplier;
use App\Models\IngredientSupply;
use App\Models\StockIngredient;
use Illuminate\Support\Facades\DB;

class ApprovisionnementsController extends Controller
{
    //
    public function index(){

        $suppliers = Supplier::all();

        return view('admin.create-appro', compact('suppliers'));
    }
        
    
    // Recherche des ingredients par les premières lettres
        public function search(Request $request)
        {
            $query = $request->input('query');
            $ingredients = Ingredient::with('unitIngredient')->where('designation', 'like', "{$query}%")->get();

            
            return response()->json($ingredients);
        }

            // enregistrement des achats ingredient
    public function storeSupply(Request $request){
       // dd($request->all());

    // Enregistrer l'approvisionnement
    $supply = IngredientSupply::create([
        'ingredient_id' => $request->input('ingredient_id'),
        'designation' => $request->input('designation'),
        'quantity' => $request->input('quantity'),
        'price' => $request->input('price'),
        'unit_ingredient_id' => $request->input('unit_ingredient_id'),
        'total_amount' => $request->input('total_amount'),
        'date' => $request->input('date'),
        'supplier_id' => $request->input('supplier_id'),
        'seuil_d_alert' => $request->input('seuil_d_alert'),
    ]);
 
    // Mettre à jour le stock de l'ingrédient
    $stockIngredient = StockIngredient::firstOrCreate(
        ['ingredient_id' => $supply->ingredient_id],
        ['main_unit' => $supply->unit_ingredient_id] // Remplacer 'kg' par l'unité appropriée si nécessaire
    );

    $stockIngredient->current_stock += $supply->quantity;
    $stockIngredient->save();

    return redirect()->back()->with('success', 'Approvisionnement enregistré et stock mis à jour.');
}


// calcul dépenses

public function showExpenses()
{

    $ingredients = IngredientSupply::all();
    // Calcul de la dépense totale

    $totalExpense = IngredientSupply::sum('total_amount');

    // Calcul de la dépense journalière
    $dailyExpenses = IngredientSupply::select(
                        DB::raw('DATE(date) as date'),
                        DB::raw('SUM(total_amount) as daily_total')
                     )
                     ->groupBy('date')
                     ->orderBy('date', 'desc')
                     ->get();

    return view('admin.depense', compact('totalExpense', 'dailyExpenses', 'ingredients'));
}

}

