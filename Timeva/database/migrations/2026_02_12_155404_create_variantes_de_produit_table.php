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
        Schema::create('variantes_de_produit', function (Blueprint $table) {
            $table->uuid('id_variant')->primary();
            $table->uuid('id_produit');
            $table->string('couleur')->nullable();
            $table->string('taille')->nullable();
            $table->string('reference')->unique()->nullable();
            $table->decimal('prix_modificateur', 10, 2)->default(0);
            $table->integer('quantite_stock')->default(0);
            $table->string('img')->nullable();
            $table->timestamp('date_creation')->useCurrent();
            $table->timestamp('date_modification')->useCurrent()->useCurrentOnUpdate();
            
            $table->foreign('id_produit')
                  ->references('id')
                  ->on('produits')
                  ->onDelete('cascade');
                  
            $table->unique(['id_produit', 'couleur', 'taille'], 'variantes_unique_combo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variantes_de_produit');
    }
};
