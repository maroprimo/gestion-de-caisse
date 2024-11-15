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
        Schema::create('approvisionnements', function (Blueprint $table) {
            $table->id(); // Colonne 'id'
            $table->string('numero_commande')->unique(); // Colonne 'Numero commande'
            $table->string('transfert')->nullable(); // Colonne 'transfert'
            $table->string('designation'); // Colonne 'designation'
            $table->decimal('prix', 10, 2); // Colonne 'Prix Un'
            $table->integer('quantite'); // Colonne 'quantité'
            $table->decimal('montant', 15, 2); // Colonne 'Montant'
            $table->string('depot_pdv_vendeur'); // Colonne 'Depot ou PDV ou vendeur'
            $table->date('date'); // Colonne 'date'
            $table->string('fournisseur'); // Colonne 'fornisseur'
            $table->timestamps(); // Colonne pour 'created_at' et 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('approvisionnements');
    }
};
