<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleIngredientUsage extends Model
{
    use HasFactory;

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
    
    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }
    
}
