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
        Schema::create('listedetails', function (Blueprint $table) {
            $table->id();
            $table->string('lds_principal',20);
            $table->string('lds_detail',20);
            $table->integer('lds_qte_pr');
            $table->integer('lds_qte_pr_par_ds');
            $table->integer('lds_qte_ds');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listedetails');
    }
};
