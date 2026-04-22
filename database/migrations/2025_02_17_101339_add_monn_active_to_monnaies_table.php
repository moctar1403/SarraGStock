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
        Schema::table('monnaies', function (Blueprint $table) {
            $table->string('monn_active',1)->after('monn_code')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('monnaies', function (Blueprint $table) {
            $table->dropColumn('monn_active');
        });
    }
};
