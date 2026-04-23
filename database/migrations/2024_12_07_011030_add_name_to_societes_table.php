<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Ajouter soc_nom si elle n'existe pas
        if (!Schema::hasColumn('societes', 'soc_nom')) {
            Schema::table('societes', function (Blueprint $table) {
                $table->string('soc_nom', 30)->nullable()->after('id');
            });
        }

        // Ajouter soc_nif si elle n'existe pas
        if (!Schema::hasColumn('societes', 'soc_nif')) {
            Schema::table('societes', function (Blueprint $table) {
                $table->string('soc_nif', 30)->nullable()->after('soc_email');
            });
        }

        // Ajouter soc_rc si elle n'existe pas
        if (!Schema::hasColumn('societes', 'soc_rc')) {
            Schema::table('societes', function (Blueprint $table) {
                $table->string('soc_rc', 30)->nullable()->after('soc_nif');
            });
        }
    }

    public function down()
    {
        Schema::table('societes', function (Blueprint $table) {
            $table->dropColumn(['soc_nom', 'soc_nif', 'soc_rc']);
        });
    }
};