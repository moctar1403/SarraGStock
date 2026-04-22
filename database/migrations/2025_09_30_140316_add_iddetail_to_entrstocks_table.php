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
        Schema::table('entrstocks', function (Blueprint $table) {
            $table->string('iddetail',20)->after('ent_motif')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entrstocks', function (Blueprint $table) {
            $table->dropColumn('iddetail');
        });
    }
};
