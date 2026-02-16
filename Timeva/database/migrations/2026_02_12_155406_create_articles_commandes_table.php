<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles_commandes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commande_id')->constrained('commandes')->onDelete('cascade');
            $table->foreignId('variant_id')->nullable()->constrained('variantes_de_produit')->onDelete('set null');
            $table->string('nom_produit');
            $table->text('infos_variante')->nullable();
            $table->decimal('prix_unitaire', 10, 2);
            $table->integer('quantite');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles_commandes');
    }
};