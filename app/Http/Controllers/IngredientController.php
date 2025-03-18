<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredient;
use App\Models\Unit;
use App\Models\Supplier;
use App\Models\UnitIngredient;
use App\Models\Product;



class IngredientController extends Controller
{
    
    public function sauveringredient(Request $request) {
        // Validation du formulaire
        //dd($request->all());
        $this->validate($request, [
            'designationp' => 'required_if:produit,0|string|max:255', // requis si produit = 0
            'product_id' => 'required_if:produit,1|nullable|exists:products,id', // requis si produit = 1
             'designation' => 'required_if:produit,1|string|max:255', // requis si produit = 1
            'main_unit' => 'required|string|max:255',
            'seuil' => 'required|numeric',
            'produit' => 'required|in:0,1',
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
    
        // Création de l'instance Ingredient
        $ingredient = new Ingredient();
    
        if ($request->input('produit') == 0) {
            // Cas Ingrédient (designation saisie manuellement)
            $ingredient->designation = $request->input('designationp');
            $ingredient->product_id = null;
        } else {
            // Cas Produit (on récupère la désignation du produit sélectionné)
            $product = Product::find($request->input('product_id'));
            if ($product) {
                $ingredient->designation = $request->input('designation'); // Utilisez la désignation du champ caché
                $ingredient->product_id = $request->input('product_id');
            } else {
                return redirect()->back()->with('error', 'Produit sélectionné introuvable.');
            }
        }
    
        $ingredient->seuil = $request->input('seuil');
        $ingredient->photo = $fileNameToStore;
        $ingredient->type = $request->input('produit');
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
    
        
            return redirect()->back()->with('success', 'Produit ou Ingrédient enregistré avec succès.');
        }
    

    


    public function index()
    {
        // Récupérer tous les produits avec leurs prix, catégories et unités
        $ingredients = Ingredient::all();   
        $products = Product::all();

        

        // Récupérer toutes les unités
        $unitingredients = UnitIngredient::all();

        // Passer toutes les données à la vue
        return view('admin.create-ingredient', compact('ingredients', 'unitingredients', 'products'));
    }

    
}