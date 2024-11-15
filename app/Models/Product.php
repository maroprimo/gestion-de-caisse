<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
            public function prices()
            {
                return $this->hasMany(ProductPrice::class, 'product_id');
            }

            // relation entre produit et ingredient plusieur produit pour plusieur ingredient

            public function ingredients()
            {
                return $this->belongsToMany(Ingredient::class)->withPivot('quantity_needed');
            }

            public function sales()
            {
                return $this->hasMany(Sale::class);
            }


            public function productIngredients()
                {
                    return $this->hasMany(ProductIngredient::class, 'product_id');
                }

                    // calcul depense produits

            public function calculateIngredientCost()
            {
                // Calcule la somme des coûts des ingrédients pour ce produit
                return $this->productIngredients->sum('ingredient_cost');
            }



}
