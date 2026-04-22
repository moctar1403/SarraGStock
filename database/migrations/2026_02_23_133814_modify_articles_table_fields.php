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
        Schema::table('articles', function (Blueprint $table) {
            $table->string('ar_reference', 200)->change(); // 
            $table->string('ar_lib', 200)->change(); // 
            $table->string('ar_description', 200)->change(); // 
            $table->string('ar_codebarre', 200)->change(); // 
            $table->string('ar_saisi_par', 200)->change(); // 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('ar_reference', 200)->change(); // 
            $table->string('ar_lib', 200)->change(); // 
            $table->string('ar_description', 200)->change(); // 
            $table->string('ar_codebarre', 200)->change(); // 
            $table->string('ar_saisi_par', 200)->change(); // 
        });
    }
};
