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
        Schema::table('operats', function (Blueprint $table) {
            $table->string('operat_type',100)->after('operat_montant')->default('');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('operats', function (Blueprint $table) {
            $table->dropColumn('operat_type');
        });
    }
};
