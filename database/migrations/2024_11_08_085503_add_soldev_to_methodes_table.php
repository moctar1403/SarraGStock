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
        Schema::table('methodes', function (Blueprint $table) {
            $table->decimal('meth_soldev',10,2)->default('0')->after('meth_solder');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('methodes', function (Blueprint $table) {
            $table->dropColumn('meth_soldev');
        });
    }
};
