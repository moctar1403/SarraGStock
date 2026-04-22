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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('cli_nom',30);
            $table->string('cli_societe',30);
            $table->string('cli_civilite',30);
            $table->string('cli_tel',20);
            $table->string('cli_adresse',200);
            $table->string('cli_email',50);
            $table->string('cli_observations',50);
            $table->string('cli_saisi_par',50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
