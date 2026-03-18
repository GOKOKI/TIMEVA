<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            $table->string('fedapay_transaction_id')->nullable()->after('pays_expedition');
            $table->string('paiement_statut')->default('non_paye')->after('fedapay_transaction_id');
            // Valeurs possibles : non_paye | paye | echec | rembourse
        });
    }

    public function down(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            $table->dropColumn(['fedapay_transaction_id', 'paiement_statut']);
        });
    }
};
