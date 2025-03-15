<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\IngredientSupply;

class ProductIngredient extends Model
{
    use HasFactory;
    protected $table = 'product_ingredients';

    protected $fillable = [
        'product_id',
        'ingredient_id',
        'quantity',
        'ingredient_cost',
        'unite',
        // ajoutez ici d'autres champs si nécessaire
    ];

    // Relation avec Ingredient
    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class, 'ingredient_id');
    }
}
