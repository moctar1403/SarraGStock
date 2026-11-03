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
        Schema::create('caisses', function (Blueprint $table) {
            $table->id();
            
            // Qui a ouvert la caisse ?
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Informations d'ouverture
            $table->dateTime('date_ouverture');
            $table->decimal('montant_initial', 10, 2)->default(0); // Le fond de caisse
            
            // Informations de clôture
            $table->dateTime('date_cloture')->nullable();
            $table->decimal('montant_final_reel', 10, 2)->nullable(); // Ce que le caissier a compté
            $table->decimal('montant_theorique', 10, 2)->nullable(); // Ce que le système a calculé
            $table->decimal('ecart', 10, 2)->nullable(); // Différence (Manquant/Excédent)
            
            // Statut : 'ouvert' ou 'ferme'
            $table->string('statut')->default('ouvert'); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caisses');
    }
};