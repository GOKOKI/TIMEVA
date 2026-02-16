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
        Schema::create('commandes', function (Blueprint $table) {
            $table->id(); // Changé de uuid à id
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Changé de uuid à foreignId
            $table->enum('statut', ['en attente', 'confirmé', 'expédié', 'livré', 'annulé'])
                  ->default('en attente');
            $table->decimal('montant', 10, 2);
            $table->text('adresse_livraison')->nullable();
            $table->string('code_postal')->nullable();
            $table->string('pays_expedition')->nullable();
            $table->string('stripe_payment_id')->nullable();
            $table->timestamps(); // Remplace date_creation et date_modification
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};