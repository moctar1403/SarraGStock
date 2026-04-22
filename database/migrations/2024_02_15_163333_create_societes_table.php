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
        Schema::create('societes', function (Blueprint $table) {
            $table->id();
            $table->string('soc_adresse',50);
            $table->string('soc_code_postal',50);
            $table->string('soc_tel',50);
            $table->string('soc_email',50);
            $table->string('soc_logo',100);
            $table->string('soc_observations',50);
            $table->string('soc_saisi_par',50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('societes');
    }
};
