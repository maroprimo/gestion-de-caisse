<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = ['sale_date', 'total_amount'];

    // Chaque instance de ce modèle est associée à une seule instance du modèle Product.

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    


    public function ingredientUsages()
    {
        return $this->hasMany(SaleIngredientUsage::class);
    }


    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }
}
