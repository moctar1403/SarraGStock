<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MethodevsSeeder extends Seeder
{
    public function run(): void
    {
        // 1) Vider la table (remet AUTO_INCREMENT à 1)
        DB::table('methodevs')->truncate();

        // 2) Insérer les valeurs initiales
        $now = now();

        DB::table('methodevs')->insert([
            [
                'mvs_sym' => 'CUMP',
                'mvs_lib' => 'Coût Unitaire Moyen Pondéré',
                'mvs_active' => 1, // Active par défaut
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'mvs_sym' => 'PEPS',
                'mvs_lib' => 'Premier Entré, Premier Sorti',
                'mvs_active' => 0,
               'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'mvs_sym' => 'DEPS',
                'mvs_lib' => 'Dernier Entré, Premier Sorti',
                'mvs_active' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        $this->command->info('✅ Methodevs insérées : 3');
    }
}