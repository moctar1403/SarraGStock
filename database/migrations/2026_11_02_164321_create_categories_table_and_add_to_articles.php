<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Table des catégories
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('nom'); // Ex: "Plats", "Boissons", "Entrées"
            $table->timestamps();
        });

        // 2. Ajout des champs dans la table articles
        Schema::table('articles', function (Blueprint $table) {
            // Lien vers la catégorie
            $table->foreignId('categorie_id')->nullable()->constrained('categories')->nullOnDelete();
            
            // Case à cocher : true = on gère le stock, false = pas de stock (plat cuisiné)
            $table->boolean('gerer_stock')->default(true); 
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropForeign(['categorie_id']);
            $table->dropColumn(['categorie_id', 'gerer_stock']);
        });
        Schema::dropIfExists('categories');
    }
};