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
        Schema::table('clients', function (Blueprint $table) {
            $table->string('cli_nom', 200)->change(); // 
            $table->string('cli_societe', 200)->change(); // 
            $table->string('cli_civilite', 200)->change(); // 
            $table->string('cli_tel', 200)->change(); // 
            $table->string('cli_email', 200)->change(); // 
            $table->string('cli_observations', 200)->change(); // 
            $table->string('cli_saisi_par', 200)->change(); // 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('cli_nom', 200)->change(); // 
            $table->string('cli_societe', 200)->change(); // 
            $table->string('cli_civilite', 200)->change(); // 
            $table->string('cli_tel', 200)->change(); // 
            $table->string('cli_email', 200)->change(); // 
            $table->string('cli_observations', 200)->change(); // 
            $table->string('cli_saisi_par', 200)->change(); // 
        });
    }
};
