<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('charges', function (Blueprint $table) {
            $table->id();
            $table->string('ch_libelle'); // Ex: Achat viande, Gaz, Loyer
            $table->decimal('ch_montant', 10, 2);
            $table->date('ch_date');
            // $table->foreignId('methode_id')->constrained('methodes'); // Pour savoir d'où sort l'argent (Caisse, Bankily...)
            $table->foreignId('user_id')->constrained('users'); // Qui a enregistré la charge
            $table->string('ch_observations')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('charges');
    }
};