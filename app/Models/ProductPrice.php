<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'unit_id', 'main_unit_price', 'sub_unit_price'];

     // Relation avec le produit>> plusieurs prix pour un produit car unité et sous unité pour un produit
     public function product()
     {
         return $this->belongsTo(Product::class);
     }
 
     // Relation avec l'unité >> plusieurs prix pour un unité 
     public function unit()
     {
         return $this->belongsTo(Unit::class);
     }


}
