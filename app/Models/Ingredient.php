<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

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
    // plusieurs ingredients appartiennent à plusieurs produits 
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity_needed');
    }
    
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
        
    // un ingredient a plusieurs unités relation entre ingrdient et unités
    public function unitingredient(){
        return $this->hasMany(UnitIngredient::class);
    }

    public function ingredientSupplies()
    {
        return $this->hasMany(IngredientSupply::class);
    }

    public function getPurchasePrice()
{
    // Vérifier si l'ingrédient est un produit (c'est-à-dire qu'il a un product_id)
    if ($this->product_id) {
        // Récupérer le dernier prix d'achat pour cet ingrédient dans ingredient_supplies
        $latestSupply = IngredientSupply::where('ingredient_id', $this->id)
            ->orderBy('date', 'desc') // Tri par date décroissant pour récupérer le dernier enregistrement
            ->first();

        return $latestSupply ? $latestSupply->price : 0; // Retourne le prix ou 0 si aucun enregistrement
    }

    return 0; // Retourne 0 si ce n'est pas un produit
}


}
