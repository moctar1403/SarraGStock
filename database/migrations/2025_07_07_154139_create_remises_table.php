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
        Schema::create('remises', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('facture_id');
            $table->foreign('facture_id')->references('id')->on('factures');
            $table->decimal('re_taux_remise',10,2)->default('0');
            $table->decimal('re_montant_facture',10,2)->default('0');
            $table->decimal('re_montant_remise',10,2)->default('0');
            $table->decimal('re_prix_tot_apres_remise',10,2)->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('remises');
    }
};
