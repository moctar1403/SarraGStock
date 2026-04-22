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
        Schema::create('entrstocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('article_id');
            $table->foreign('article_id')->references('id')->on('articles');
            $table->string('ent_fournisseur')->default('0');
            $table->integer('ent_qte')->default('0');
            $table->decimal('ent_prix_achat',10,2);
            $table->decimal('ent_prix_vente',10,2);
            $table->date('ent_date');
            $table->string('ent_observations',50);
            $table->string('ent_saisi_par',50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entrstocks');
    }
};
