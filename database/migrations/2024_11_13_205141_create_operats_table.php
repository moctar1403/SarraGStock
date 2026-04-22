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
        Schema::create('operats', function (Blueprint $table) {
            $table->id();
            $table->string('operat_meth_id');
            $table->string('operat_vent_id');
            $table->string('operat_tr_id');
            $table->decimal('operat_montant',10,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operats');
    }
};
