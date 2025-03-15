<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngredientSupply extends Model
{
    use HasFactory;
    protected $fillable = [
        'ingredient_id',
        'designation',
        'quantity',
        'price',
        'total_amount',
        'date',
        'supplier_id',
        'seuil_d_alert',
        'unit_ingredient_id',
        'unit_ingredient_text',
        'product_id', 
        // Ajoutez d'autres champs si nécessaire
    ];

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }

    // Méthode pour récupérer le prix d'achat le plus récent de l'ingrédient
    public function getLatestPurchasePrice()
    {
        if ($this->ingredient_id) {
            $latestSupply = IngredientSupply::where('ingredient_id', $this->ingredient_id)
                ->orderBy('date', 'desc') // Récupère le plus récent
                ->first();

            return $latestSupply ? $latestSupply->price : null;
        }
        return null;
    }
}
