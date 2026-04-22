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
        Schema::table('factures', function (Blueprint $table) {
            $table->decimal('fa_t_remise',10,2)->after('fa_tot')->default(0);
            $table->decimal('fa_m_remise',10,2)->after('fa_t_remise')->default(0);
            $table->decimal('fa_tot_apres_remise',10,2)->after('fa_m_remise')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('factures', function (Blueprint $table) {
            $table->dropColumn('fa_t_remise');
            $table->dropColumn('fa_m_remise');
            $table->dropColumn('fa_tot_apres_remise');
        });
    }
};
