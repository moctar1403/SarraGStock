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
        Schema::table('fournisseurs', function (Blueprint $table) {
            $table->string('four_nom', 200)->change(); // 
            $table->string('four_societe', 200)->change(); // 
            $table->string('four_civilite', 200)->change(); // 
            $table->string('four_tel', 200)->change(); // 
            $table->string('four_adresse', 200)->change(); // 
            $table->string('four_email', 200)->change(); // 
            $table->string('four_observations', 200)->change(); // 
            $table->string('four_saisi_par', 200)->change(); // 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fournisseurs', function (Blueprint $table) {
            $table->string('four_nom', 200)->change(); // 
            $table->string('four_societe', 200)->change(); // 
            $table->string('four_civilite', 200)->change(); // 
            $table->string('four_tel', 200)->change(); // 
            $table->string('four_adresse', 200)->change(); // 
            $table->string('four_email', 200)->change(); // 
            $table->string('four_observations', 200)->change(); // 
            $table->string('four_saisi_par', 200)->change(); // 
        });
    }
};
