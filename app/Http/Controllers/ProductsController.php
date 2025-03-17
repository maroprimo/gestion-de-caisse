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
            'produit' => 'required|in:0,1',
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
        $product->type_produit = $request->input('produit');
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

                   // Récupérer toutes les unités
                $ingredientSupply = ingredientSupply::all();

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
             // Récupérer toutes les unités
            $units = Unit::all();
            $ingredients = Ingredient::all();
            return view('admin.create-productingredients', compact('products', 'ingredients', 'units'));
        }
        

        //ajout 
        
        public function storeProductIngredients(Request $request)
        {
            $productId = $request->input('product_id');
            $unit = $request->input('unite'); // Récupérer l'unité
            $ingredients = $request->input('ingredients', []); // Valeur par défaut : tableau vide
        
            // Vérifier si c'est un produit de type "produit de marchandises"
            $product = Product::find($productId);
            
            // Si le produit est de type "produit de marchandises", on ne traite pas les ingrédients
            if ($product && $product->type_produit == '1') {
                ProductIngredient::create([
                    'product_id' => $productId,
                    'ingredient_id' => null, // Aucun ingrédient
                    'quantity' => 1, // Quantité par défaut ou calculée
                    'ingredient_cost' => null, // Aucun coût pour les produits de marchandises
                    'unite' => $unit, // L'unité peut être renseignée
                ]);
        
                return redirect()->back()->with('success', 'Produit de marchandises ajouté avec succès!');
            }
        
            // Si des ingrédients sont envoyés
            if (!empty($ingredients)) {
                foreach ($ingredients as $ingredient) {
                    $ingredientId = $ingredient['ingredient_id'] ?? null;
                    $ingredientCost = null;
        
                    if ($ingredientId) {
                        $ingredientSupply = IngredientSupply::where('ingredient_id', $ingredientId)
                            ->orderBy('date', 'desc')
                            ->first();
        
                        if ($ingredientSupply) {
                            $ingredientCost = $ingredientSupply->price * $ingredient['quantity'];
                        }
                    }

        
                    
                    ProductIngredient::create([
                        'product_id' => $productId,
                        'ingredient_id' => $ingredientId,
                        'quantity' => $ingredient['quantity'],
                        'ingredient_cost' => $ingredientCost,
                        'unite' => $unit, // L'unité renseignée
                    ]);

                }
        
                return redirect()->back()->with('success', 'Ingrédients ajoutés au produit avec succès!');
            }
        
            return redirect()->back()->with('error', 'Aucun ingrédient sélectionné.');
        }
        



        public function getUnits($productId): JsonResponse
        {
            try {
                // Vérifie si le produit existe
                $product = Product::find($productId);
                if (!$product) {
                    return response()->json(['error' => 'Produit non trouvé'], 404);
                }
        
                // Récupère les unités associées au produit
                $units = Unit::where('product_id', $productId)->first();
        
                if (!$units) {
                    return response()->json(['error' => 'Aucune unité trouvée'], 404);
                }
        
                // Retourne les unités au format JSON
                return response()->json([
                    'main_unit' => $units->main_unit,
                    'sub_unit' => $units->sub_unit ?? null  // Gérer le cas où sub_unit est NULL
                ]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }



        // AP product par catégorie

        public function getProductsByCategory($category_id)
            {
                // Vérifier si la catégorie existe
                $category = Category::find($category_id);

                if (!$category) {
                    return response()->json(['message' => 'Catégorie non trouvée'], 404);
                }

                // Récupérer les produits liés à cette catégorie
                $products = Product::where('category_id', $category_id)->get();

                // Retourner la réponse en JSON
                return response()->json([
                    'category' => $category->name,
                    'products' => $products
                ]);
            }

}


