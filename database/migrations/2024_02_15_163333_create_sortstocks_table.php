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
        Schema::create('sortstocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('article_id');
            $table->foreign('article_id')->references('id')->on('articles');
            $table->string('sor_vente')->default('0');
            $table->integer('sor_qte')->default('0');
            $table->decimal('sor_prix_achat',10,2);
            $table->decimal('sor_prix_vente',10,2);
            $table->date('sor_date');
            $table->string('sor_motif',50);
            $table->string('sor_observations',50);
            $table->string('sor_saisi_par',50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sortstocks');
    }
};
