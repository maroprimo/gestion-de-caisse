<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\IngredientSupply;
use Illuminate\Support\Facades\Log;


class Product extends Model
{
        use HasFactory;

        // un enregistrement peu avoir plusieurs sous unités dans la table units
        // exemple: pizza peut avoir unités boites, et unités portions
        public function units()
        {
            return $this->hasMany(Unit::class);
        }

        // plusieurs enregistrement dans la table produits peut avoir un meme categories
        // pizza et tacos, meme categories snak

        public function category()
        {
            return $this->belongsTo(Category::class);
        }

               // Définir la relation avec la table des prix
               // un produit peut avoir plusieurs prix
            public function prices()
            {
                return $this->hasMany(ProductPrice::class, 'product_id');
            }

            // relation entre produit et ingredient plusieur produit pour plusieur ingredient

            public function ingredients()
            {
                return $this->belongsToMany(Ingredient::class, 'product_ingredients')
                            ->withPivot('quantity_needed');
            }
            // un enregistrement (un produit) peut être vendu plusieurs fois
            public function sales()
            {
                return $this->hasMany(Sale::class);
            }
            // un produits peut avoir plusieurs enregstrement dans la table productIngredients
            // product_id 29 correspond à ingredient_id: 1,2,3...etc

            public function productIngredients()
                {
                    return $this->hasMany(ProductIngredient::class, 'product_id');
                }

                    // calcul depense produits

            public function calculateIngredientCost()
            {
                // Calcule la somme des coûts des ingrédients utilisé pour ce produit
                // le calcule se fait dansla table productingredients
                return $this->productIngredients->sum('ingredient_cost');
            }


            public function getPurchasePrice()
            {
                // Trouver l'ingrédient correspondant à ce produit via product_id
                $ingredient = Ingredient::where('product_id', $this->id)->first();
            
                if ($ingredient) {
                    // Récupérer le dernier prix d'achat dans ingredient_supplies
                    $latestSupply = IngredientSupply::where('ingredient_id', $ingredient->id)
                        ->orderBy('date', 'desc') // On prend le dernier prix enregistré
                        ->first();
            
                    return $latestSupply ? $latestSupply->price : 0; // Retourne le prix ou 0 si aucun enregistrement
                }
            
                return 0; // Si aucun ingrédient associé, on retourne 0
            }
               
            
            
            
            
            
            

}
