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
        Schema::table('entrstocks', function (Blueprint $table) {
            $table->decimal('ent_qte',10,2)->default('0')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entrstocks', function (Blueprint $table) {
            $table->integer('ent_qte')->default('0')->change();
        });
    }
};
