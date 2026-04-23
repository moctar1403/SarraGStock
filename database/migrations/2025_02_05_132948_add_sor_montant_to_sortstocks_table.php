<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Ajouter la colonne 'sor_montant_t_achat' si elle n'existe pas
        if (!Schema::hasColumn('sortstocks', 'sor_montant_t_achat')) {
            Schema::table('sortstocks', function (Blueprint $table) {
                $table->decimal('sor_montant_t_achat', 10, 2)->after('sor_prix_vente')->default(0);
            });
        }

        // Ajouter la colonne 'sor_montant_t_vente' si elle n'existe pas
        if (!Schema::hasColumn('sortstocks', 'sor_montant_t_vente')) {
            Schema::table('sortstocks', function (Blueprint $table) {
                $table->decimal('sor_montant_t_vente', 10, 2)->after('sor_montant_t_achat')->default(0);
            });
        }
    }

    public function down()
    {
        Schema::table('sortstocks', function (Blueprint $table) {
            $table->dropColumn(['sor_montant_t_achat', 'sor_montant_t_vente']);
        });
    }
};