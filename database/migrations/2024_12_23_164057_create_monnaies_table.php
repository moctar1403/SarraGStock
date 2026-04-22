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
        Schema::create('monnaies', function (Blueprint $table) {
            $table->id();
            $table->string('monn_lib',30);
            $table->string('monn_sym',20);
            $table->string('monn_code',20);
            $table->string('monn_saisi_par',50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monnaies');
    }
};
