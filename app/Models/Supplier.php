<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

        // Définir les champs qui peuvent être assignés en masse
        protected $fillable = ['name', 'contact', 'address'];

    public function ingredients()
    {
        return $this->hasMany(Ingredient::class);
    }
}
