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
        Schema::create('profils', function (Blueprint $table) {
            $table->id(); // Changé de uuid à id
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade'); // Changé de uuid à foreignId
            $table->string('prenom')->nullable();
            $table->string('nom')->nullable();
            $table->string('tel')->nullable();
            $table->text('adresse')->nullable();
            $table->string('ville')->nullable();
            $table->string('code_postal')->nullable();
            $table->string('pays')->default('France');
            $table->enum('role', ['admin', 'user'])->default('user');
            $table->timestamps(); // Remplace date_creation et date_modification
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profils');
    }
};