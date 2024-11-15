<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredient;
use App\Models\Unit;
use App\Models\Supplier;
use App\Models\UnitIngredient;



class IngredientController extends Controller
{
    
    public function sauveringredient(Request $request) {
        // Validation du formulaire
        $this->validate($request, [
            'designation' => 'required|string|max:255',
            'main_unit' => 'required|string|max:255',
            'seuil' => 'required|numeric',
            'photo' => 'required|image|mimes:JPG,jpg,jpeg,png,gif|max:1999',
            'description' => 'required'
        ]);
    
        // Configuration de l'image
        if ($request->hasFile('photo')) {
            $fileNameWithExt = $request->file('photo')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('photo')->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            $path = $request->file('photo')->storeAs('public/product_images', $fileNameToStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
        }
    
        // Enregistrement du produit dans la base de données
        $ingredient = new Ingredient();
        $ingredient->designation = $request->input('designation');
        $ingredient->seuil = $request->input('seuil');
        $ingredient->photo = $fileNameToStore;
        $ingredient->description = $request->input('description');
        $ingredient->save();
    

        //$unit->conversion_rate = 1; // valeur par défaut pour l'unité principale
        //$unit->save();
    
        // Vérifier si des sous-unités existent
        if ($request->has('subUnit') && $request->has('conversionRate')) {
            $subUnits = $request->input('subUnit');
            $conversionRates = $request->input('conversionRate');
    
            foreach ($subUnits as $index => $subUnitName) {
                if (!empty($subUnitName) && isset($conversionRates[$index])) {
                    $conversionRate = $conversionRates[$index];
    
                    // Créez et enregistrez chaque sous-unité
                    $subUnit = new UnitIngredient();
                    $subUnit->sub_unit = $subUnitName;
                    $subUnit->conversion_rate = $conversionRate;

                }
            }

            
            // Enregistrement de l'unité principale
            $unit = new UnitIngredient();
            $unit->main_unit = $request->input('main_unit');
            $unit->ingredient_id = $ingredient->id;
            $unit->sub_unit = $subUnitName;
            $unit->conversion_rate = $conversionRate;

            $unit->save();

        }else{
            
            // Enregistrement de l'unité principale
            $unit = new UnitIngredient();
            $unit->main_unit = $request->input('main_unit');
            $unit->ingredient_id = $ingredient->id;
            $unit->sub_unit = null;
            $unit->conversion_rate = 1;

            $unit->save();
        }



    return redirect()->back()->with('success', 'Produit et sous-unités enregistrés avec succès.');
    }



    public function index()
    {
        // Récupérer tous les produits avec leurs prix, catégories et unités
        $ingredients = Ingredient::all();   

        

        // Récupérer toutes les unités
        $unitingredients = UnitIngredient::all();

        // Passer toutes les données à la vue
        return view('admin.create-ingredient', compact('ingredients', 'unitingredients'));
    }

    
}
