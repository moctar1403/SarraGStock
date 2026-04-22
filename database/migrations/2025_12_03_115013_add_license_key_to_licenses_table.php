<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('licenses', function (Blueprint $table) {
        $table->string('license_key')->unique()->after('id');
    });
}

public function down()
{
    Schema::table('licenses', function (Blueprint $table) {
        $table->dropColumn('license_key');
    });
}
};
