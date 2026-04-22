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
        Schema::create('fournisseurs', function (Blueprint $table) {
            $table->id();
            $table->string('four_nom',50);
            $table->string('four_societe',30);
            $table->string('four_civilite',50);
            $table->string('four_tel',50);
            $table->string('four_adresse',50);
            $table->string('four_email',50);
            $table->string('four_observations',50)->nullable();
            $table->string('four_saisi_par',50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fournisseurs');
    }
};
