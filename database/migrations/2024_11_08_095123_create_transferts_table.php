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
        Schema::create('transferts', function (Blueprint $table) {
            $table->id();
            $table->string('tr_meth_env_id');
            $table->string('tr_meth_env_nom');
            $table->string('tr_meth_ben_id');
            $table->string('tr_meth_ben_nom');
            $table->decimal('tr_montant',10,2);
            $table->decimal('tr_frais',10,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transferts');
    }
};
