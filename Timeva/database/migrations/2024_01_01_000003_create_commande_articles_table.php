<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commande_articles', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('commande_id')->constrained('commandes')->onDelete('cascade');
            $table->string('nom_produit');
            $table->json('infos_variante')->nullable();
            $table->unsignedInteger('quantite');
            $table->decimal('prix_unitaire', 10, 2);
            $table->decimal('total', 10, 2);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commande_articles');
    }
};
