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
            $table->renameColumn('operat_pa_id', 'operat_pa_cli_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('operats', function (Blueprint $table) {
            $table->renameColumn('operat_pa_cli_id', 'operat_pa_id');
        });
    }
};
