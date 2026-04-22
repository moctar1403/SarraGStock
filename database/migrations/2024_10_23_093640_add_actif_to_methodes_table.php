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
            $table->string('meth_active')->enum('0','1')->default('1')->after('meth_tel');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('methodes', function (Blueprint $table) {
            $table->dropColumn('meth_active');
        });
    }
};
