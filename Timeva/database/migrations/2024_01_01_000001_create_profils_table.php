<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profils', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
            $table->string('prenom', 255)->nullable();
            $table->string('nom', 255)->nullable();
            $table->string('tel', 20)->nullable();
            $table->string('adresse', 255)->nullable();
            $table->string('ville', 100)->nullable();
            $table->string('code_postal', 10)->nullable();
            $table->string('pays', 100)->nullable();
            $table->string('role')->default('client');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profils');
    }
};
