<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MethodesSeeder extends Seeder
{
    public function run(): void
    {
        // 1) Vider la table (remet AUTO_INCREMENT à 1)
        DB::table('methodes')->truncate();

        // 2) Insérer les valeurs initiales
        $now = now();

        DB::table('methodes')->insert([
            ['meth_nom' => 'Espèce',  'meth_tel' => '12345678', 'meth_active' => '1', 'meth_solder' => 0, 'meth_soldev' => 0, 'created_at' => $now, 'updated_at' => $now],
            ['meth_nom' => 'Crédit',  'meth_tel' => '12345678', 'meth_active' => '1', 'meth_solder' => 0, 'meth_soldev' => 0, 'created_at' => $now, 'updated_at' => $now],
            ['meth_nom' => 'Bankily', 'meth_tel' => '12345678', 'meth_active' => '1', 'meth_solder' => 0, 'meth_soldev' => 0, 'created_at' => $now, 'updated_at' => $now],
            ['meth_nom' => 'Masrivi', 'meth_tel' => '12345678', 'meth_active' => '1', 'meth_solder' => 0, 'meth_soldev' => 0, 'created_at' => $now, 'updated_at' => $now],
            ['meth_nom' => 'Sedad',   'meth_tel' => '12345678', 'meth_active' => '1', 'meth_solder' => 0, 'meth_soldev' => 0, 'created_at' => $now, 'updated_at' => $now],
        ]);

        $this->command->info('✅ Methodes insérées : 5');
    }
}