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
        Schema::table('sunites', function (Blueprint $table) {
            $table->string('sunit_lib', 200)->change(); // 
            $table->string('sunit_unite_id', 200)->change(); // 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sunites', function (Blueprint $table) {
            $table->string('sunit_lib', 200)->change(); // 
            $table->string('sunit_unite_id', 200)->change(); // 
        });
    }
};
