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
        Schema::table('sortstocks', function (Blueprint $table) {
            $table->decimal('sor_montant_t_achat',10,2)->after('sor_prix_vente')->default('0');
            $table->decimal('sor_montant_t_vente',10,2)->after('sor_montant_t_achat')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sortstocks', function (Blueprint $table) {
            $table->dropColumn('sor_montant_t_achat');
            $table->dropColumn('sor_montant_t_vente');
        });
    }
};
