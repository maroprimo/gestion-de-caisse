<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;
        // Définir les champs qui peuvent être assignés en masse
    protected $fillable = [
            'name',          // Nom de l'ingrédient
            'stock_quantity',      // Quantité de l'ingrédient
            'unit_id',          // Unité de l'ingrédient
            'supplier_id',   // Fournisseur
            'purchase_price',         // Prix de l'ingrédient
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity_needed');
    }
    
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function unitingredient(){
        return $this->hasMany(UnitIngredient::class);
    }
}
