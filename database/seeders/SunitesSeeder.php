<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SunitesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('sunites')->truncate();

        // Récupération dynamique des IDs parents depuis la table `unites`
        $unites = DB::table('unites')->pluck('id', 'unit_lib');

        // Sécurité : si `unites` n'est pas encore seedée, on arrête
        if ($unites->isEmpty()) {
            $this->command->error('❌ La table unites est vide. Lance UnitesSeeder avant SunitesSeeder.');
            return;
        }

        $now = now();

        DB::table('sunites')->insert([
            ['sunit_lib' => 'Unité',      'sunit_unite_id' => $unites['unité'],      'created_at' => $now, 'updated_at' => $now],
            ['sunit_lib' => 'Kilogramme', 'sunit_unite_id' => $unites['Kilogramme'], 'created_at' => $now, 'updated_at' => $now],
            ['sunit_lib' => 'Gramme',     'sunit_unite_id' => $unites['Kilogramme'], 'created_at' => $now, 'updated_at' => $now],
            ['sunit_lib' => 'Litre',      'sunit_unite_id' => $unites['Litre'],      'created_at' => $now, 'updated_at' => $now],
            ['sunit_lib' => 'Millilitre', 'sunit_unite_id' => $unites['Litre'],      'created_at' => $now, 'updated_at' => $now],
            ['sunit_lib' => 'Mètre',      'sunit_unite_id' => $unites['Mètre'],      'created_at' => $now, 'updated_at' => $now],
            ['sunit_lib' => 'Centimètre', 'sunit_unite_id' => $unites['Mètre'],      'created_at' => $now, 'updated_at' => $now],
        ]);

        $this->command->info('✅ Sunites insérées : 7');
    }
}