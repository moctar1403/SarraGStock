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
        Schema::table('societes', function (Blueprint $table) {
            $table->string('soc_nom',30)->after('id');
            $table->string('soc_nif',30)->after('soc_email');
            $table->string('soc_rc',30)->after('soc_nif');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('societes', function (Blueprint $table) {
            $table->dropColumn('soc_nom');
            $table->dropColumn('soc_nif');
            $table->dropColumn('soc_rc');
        });
    }
};
