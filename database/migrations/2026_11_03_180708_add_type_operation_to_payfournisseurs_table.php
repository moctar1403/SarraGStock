<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payfournisseurs', function (Blueprint $table) {
            // 'paiement' ou 'encaissement'
            $table->string('type_operation')->default('paiement')->after('fournisseur_id');
        });
    }

    public function down(): void
    {
        Schema::table('payfournisseurs', function (Blueprint $table) {
            $table->dropColumn('type_operation');
        });
    }
};