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
        Schema::table('payfournisseurs', function (Blueprint $table) {
            $table->decimal('fpay_frais',10,2)->default('0')->after('fpay_montant');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payfournisseurs', function (Blueprint $table) {
            $table->dropColumn('fpay_frais');
        });
    }
};
