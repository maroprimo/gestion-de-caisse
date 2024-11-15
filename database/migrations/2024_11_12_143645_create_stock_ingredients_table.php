<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_ingredients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ingredient_id')->constrained()->onDelete('cascade');
            $table->decimal('current_stock', 10, 2)->default(0); // Par exemple, pour stocker jusqu'à 99999999.99 unités
            $table->string('main_unit'); // Pour savoir dans quelle unité est le stock (kg, litre, etc.)
            $table->timestamps(); // Inclut `created_at` et `updated_at`
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_ingredients');
    }
};
