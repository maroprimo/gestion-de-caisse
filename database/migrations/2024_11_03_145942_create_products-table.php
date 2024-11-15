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
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // id
            $table->string('designation'); // designation - texte
            $table->string('unite'); // unité - texte
            $table->string('product_category'); // product category - texte
            $table->integer('seuil'); // seuil - number
            $table->string('photo')->nullable(); // photo - image (nom du fichier image, nullable)
            $table->decimal('prix_unite_1', 8, 2); // prix unité 1 - number avec 8 chiffres et 2 décimales
            $table->decimal('prix_unite_2', 8, 2); // prix unité 2 - number avec 8 chiffres et 2 décimales
            $table->timestamps(); // timestamps pour created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
