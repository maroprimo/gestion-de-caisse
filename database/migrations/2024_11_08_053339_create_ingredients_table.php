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
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('unit_id'); // Référence vers la table unités
            $table->float('stock_quantity'); // Quantité en stock
            $table->unsignedBigInteger('supplier_id'); // Référence vers la table fournisseurs
            $table->decimal('purchase_price', 10, 2); // Prix d'achat unitaire
            $table->timestamps();
    
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingredients');
    }
};
