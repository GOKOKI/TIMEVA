<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('variantes_de_produit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_produit')->constrained('produits')->onDelete('cascade');
            $table->string('couleur')->nullable();
            $table->string('taille')->nullable();
            $table->string('reference')->unique()->nullable();
            $table->decimal('prix_modificateur', 10, 2)->default(0);
            $table->integer('quantite_stock')->default(0);
            $table->string('img')->nullable();
            $table->timestamps();
            $table->unique(['id_produit', 'couleur', 'taille'], 'variantes_unique_combo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('variantes_de_produit');
    }
};