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
            $table->string('soc_nom', 200)->change(); // 
            $table->string('soc_adresse', 200)->change(); // 
            $table->string('soc_code_postal', 200)->change(); // 
            $table->string('soc_tel', 200)->change(); // 
            $table->string('soc_email', 200)->change(); // 
            $table->string('soc_nif', 200)->change(); // 
            $table->string('soc_rc', 200)->change(); // 
            $table->string('soc_logo', 200)->change(); // 
            $table->string('soc_observations', 200)->change(); // 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('societes', function (Blueprint $table) {
            $table->string('soc_nom', 200)->change(); // 
            $table->string('soc_adresse', 200)->change(); // 
            $table->string('soc_code_postal', 200)->change(); // 
            $table->string('soc_tel', 200)->change(); // 
            $table->string('soc_email', 200)->change(); // 
            $table->string('soc_nif', 200)->change(); // 
            $table->string('soc_rc', 200)->change(); // 
            $table->string('soc_logo', 200)->change(); // 
            $table->string('soc_observations', 200)->change(); // 
        });
    }
};
