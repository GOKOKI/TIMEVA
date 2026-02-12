<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articles_commandes', function (Blueprint $table) {
            $table->uuid('id_article')->primary();
            $table->uuid('commande_id');
            $table->uuid('variant_id')->nullable();
            $table->string('nom_produit');
            $table->text('infos_variante')->nullable();
            $table->decimal('prix_unitaire', 10, 2);
            $table->integer('quantite');
            $table->timestamp('date_creation')->useCurrent();
            
            $table->foreign('commande_id')
                  ->references('id')
                  ->on('commandes')
                  ->onDelete('cascade');
                  
            $table->foreign('variant_id')
                  ->references('id_variant')
                  ->on('variantes_de_produit')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles_commandes');
    }
};
