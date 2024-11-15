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
        // Ajoutez d'autres champs si nécessaire
    ];
}
