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
            $table->string('ent_motif',20)->after('ent_observations')->default('achat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entrstocks', function (Blueprint $table) {
            $table->dropColumn('ent_motif');
        });
    }
};
