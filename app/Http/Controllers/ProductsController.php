<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Unit;
use App\Models\ProductPrice;
use Illuminate\Http\JsonResponse;
use App\Models\ProductIngredient;
use App\Models\Ingredient;
use App\Models\IngredientSupply;


class ProductsController extends Controller
{
    //
    public function sauverproduit(Request $request) {
        // Validation du formulaire
        $this->validate($request, [
            'designation' => 'required|string|max:255',
            'main_unit' => 'required|string|max:255',
            'seuil' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
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
        $product = new Product();
        $product->designation = $request->input('designation');
        //$product->main_unit = $request->input('main_unit');
        $product->seuil = $request->input('seuil');
        $product->category_id = $request->input('category_id');
        $product->photo = $fileNameToStore;
        $product->description = $request->input('description');
        $product->save();
    

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
                    $subUnit = new Unit();
                    $subUnit->sub_unit = $subUnitName;
                    $subUnit->conversion_rate = $conversionRate;

                }
            }

            
            // Enregistrement de l'unité principale
            $unit = new Unit();
            $unit->main_unit = $request->input('main_unit');
            $unit->product_id = $product->id;
            $unit->sub_unit = $subUnitName;
            $unit->conversion_rate = $conversionRate;

            $unit->save();

        }else{
            
            // Enregistrement de l'unité principale
            $unit = new Unit();
            $unit->main_unit = $request->input('main_unit');
            $unit->product_id = $product->id;
            $unit->sub_unit = null;
            $unit->conversion_rate = 1;

            $unit->save();
        }



    return redirect()->back()->with('success', 'Produit et sous-unités enregistrés avec succès.');


}


            public function index()
            {
                // Récupérer tous les produits avec leurs prix, catégories et unités
                $produits = Product::with(['category', 'prices', 'units'])->get();   

                // Récupérer toutes les catégories principales (avec sous-catégories si nécessaire)
                $categories = Category::whereNull('parent_id')->with('subCategories.subCategories')->get();

                // Récupérer toutes les unités
                $units = Unit::all();

                // Passer toutes les données à la vue
                return view('admin.produit-vente', compact('produits', 'categories', 'units'));
            }



        // Recherche des produits par les premières lettres
        public function search(Request $request)
        {
            $query = $request->input('query');
            $produits = Product::with('units')->where('designation', 'like', "{$query}%")->get();

            
            return response()->json($produits);
        }



        
    
        // Ajouter les prix au produit et aux sous-unités
        public function addPrice(Request $request)
        {
            $request->validate([
                'produit_id' => 'required|exists:products,id',
                'main_unit_price' => 'required|numeric',
                'sous_unites.*.id' => 'exists:units,id',
                'sous_unites.*.prix' => 'nullable|numeric',
            ]);


            // Enregistrer les prix pour les sous-unités, si présents
            if (isset($request->sous_unites) && is_array($request->sous_unites)) {
                foreach ($request->sous_unites as $sousUnite) {
                    if (isset($sousUnite['prix'])) {
                        $productPriceSubUnit = new ProductPrice();
                        $productPriceSubUnit->sub_unit_price = $sousUnite['prix'];  // Prix de la sous-unité
                        
                    }
                }
                $productPrice = new ProductPrice();
                $productPrice->product_id = $request->input('produit_id');
                $productPrice->main_unit_price = $request->input('main_unit_price');  // Colonne pour le prix principal
                $productPrice->unit_id = null; // Mettre unit_id à null pour l'unité principale
                $productPrice->sub_unit_price = $sousUnite['prix'];
                $productPrice->save();
            } 
            else{
                $productPrice = new ProductPrice();
                $productPrice->product_id = $request->input('produit_id');
                $productPrice->main_unit_price = $request->input('main_unit_price');  // Colonne pour le prix principal
                $productPrice->unit_id = null; // Mettre unit_id à null pour l'unité principale
                $productPrice->sub_unit_price = null;
                $productPrice->save();

            }
            return redirect()->route('admin.produitVente')->with('success', 'Les prix ont été enregistrés avec succès.');
        
        }



        // récupération api json

        public function getProductsGroupedByCategory(): JsonResponse
        {
            // Charger les produits avec leurs prix et catégories
            $products = Product::with(['prices', 'category'])  // Charger les prix et catégories
                               ->get();
    
            // Regrouper les produits par nom de catégorie
            $productsData = $products->groupBy(function($product) {
                return $product->category ? $product->category->category_name : 'Uncategorized'; // Utiliser le nom de la catégorie
            })->map(function ($categoryProducts) {
                return $categoryProducts->flatMap(function ($product) {
                    $productEntries = [];
    
                    // Récupérer le premier prix associé au produit
                    $priceData = $product->prices->first();
    
                    // Ajouter une entrée pour le prix de l'unité principale, si disponible
                    if ($priceData && $priceData->main_unit_price !== null) {
                        $productEntries[] = [
                            'id' => $product->id,
                            'name' => $product->designation,
                            'main_unit_price' => $priceData->main_unit_price,
                            'photo' => $product->photo,
                        ];
                    }
    
                    // Ajouter une entrée pour le prix de la sous-unité, si disponible
                    if ($priceData && $priceData->sub_unit_price !== null) {
                        $productEntries[] = [
                            'id' => $product->id,
                            'name' => $product->designation,
                            'sub_unit_price' => $priceData->sub_unit_price,
                            'photo' => $product->photo,
                        ];
                    }
    
                    return $productEntries;
                });
            });
    
            return response()->json($productsData);
        }



        //ajout ingredient


        //

        public function createproductingre()
        
        {
            // on va récupérer tous les produits en relation avec model product>productIngredient(pivot)>ingredient
            // ici productIngredient contient une methode ingredient s qui défini la relation avec la table product
            // productIngredient et prices dans product et ingredient dans productIngredients
            $products = Product::with(['productIngredients.ingredient', 'prices'])->get();

            $ingredients = Ingredient::all();
            return view('admin.create-productingredients', compact('products', 'ingredients'));
        }
        

        //ajout 
        
        public function storeProductIngredients(Request $request)
        {
            $productId = $request->input('product_id');
            $ingredients = $request->input('ingredients');
        
            foreach ($ingredients as $ingredient) {
                // Récupérer le prix unitaire le plus récent pour cet ingrédient
                $ingredientSupply = IngredientSupply::where('ingredient_id', $ingredient['ingredient_id'])
                    ->orderBy('date', 'desc') // Assurez-vous que la date est la plus récente
                    ->first();
                    
        
                if ($ingredientSupply) {
                    // Calculer le coût total pour cet ingrédient
                    $ingredientCost = $ingredientSupply->price * $ingredient['quantity'];
        
                    // Créer une nouvelle entrée dans la table product_ingredients
                    ProductIngredient::create([
                        'product_id' => $productId,
                        'ingredient_id' => $ingredient['ingredient_id'],
                        'quantity' => $ingredient['quantity'],
                        'ingredient_cost' => $ingredientCost, // Stocker le coût de cet ingrédient dans product_ingredients
                    ]);
                    
                }
            }
        
            return redirect()->back()->with('success', 'Ingrédients ajoutés au produit avec succès !');
        }






}
