<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockIngredient extends Model
{
    use HasFactory;
    protected $fillable = [
        'ingredient_id',
        'main_unit',
        'current_stock',
        // Ajoutez d'autres champs nécessaires ici
    ];

        // Relation avec ProductIngredient
        public function productIngredients()
        {
            return $this->hasMany(ProductIngredient::class, 'ingredient_id', 'id');
        }


            // Relation avec l'ingrédient correspondant
        public function ingredient()
        {
            return $this->belongsTo(Ingredient::class, 'ingredient_id');
        }

        public function unitIngredient()
        {
            return $this->belongsTo(UnitIngredient::class, 'ingredient_id', 'ingredient_id');
        }
}
