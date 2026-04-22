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
            $table->string('operat_re_id',100)->after('operat_pa_id')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('operats', function (Blueprint $table) {
            $table->dropColumn('operat_re_id');
        });
    }
};
