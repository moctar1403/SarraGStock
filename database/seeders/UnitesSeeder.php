<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('unites')->truncate();

        $now = now();

        DB::table('unites')->insert([
            ['unit_lib' => 'unité',             'created_at' => $now, 'updated_at' => $now],
            ['unit_lib' => 'Kilogramme',        'created_at' => $now, 'updated_at' => $now],
            ['unit_lib' => 'Litre',             'created_at' => $now, 'updated_at' => $now],
            ['unit_lib' => 'Mètre',             'created_at' => $now, 'updated_at' => $now],
            ['unit_lib' => 'Article de détail', 'created_at' => $now, 'updated_at' => $now],
        ]);

        $this->command->info('✅ Unites insérées : 5');
    }
}