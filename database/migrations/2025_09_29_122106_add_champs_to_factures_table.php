<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Ajouter la colonne 'fa_t_remise' si elle n'existe pas
        if (!Schema::hasColumn('factures', 'fa_t_remise')) {
            Schema::table('factures', function (Blueprint $table) {
                $table->decimal('fa_t_remise', 10, 2)->after('fa_tot')->default(0);
            });
        }

        // Ajouter la colonne 'fa_m_remise' si elle n'existe pas
        if (!Schema::hasColumn('factures', 'fa_m_remise')) {
            Schema::table('factures', function (Blueprint $table) {
                $table->decimal('fa_m_remise', 10, 2)->after('fa_t_remise')->default(0);
            });
        }

        // Ajouter la colonne 'fa_tot_apres_remise' si elle n'existe pas
        if (!Schema::hasColumn('factures', 'fa_tot_apres_remise')) {
            Schema::table('factures', function (Blueprint $table) {
                $table->decimal('fa_tot_apres_remise', 10, 2)->after('fa_m_remise')->default(0);
            });
        }
    }

    public function down()
    {
        Schema::table('factures', function (Blueprint $table) {
            $table->dropColumn(['fa_t_remise', 'fa_m_remise', 'fa_tot_apres_remise']);
        });
    }
};