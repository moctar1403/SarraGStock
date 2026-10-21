<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MonnaiesSeeder extends Seeder
{
    public function run(): void
    {
        // Vider la table (remet AUTO_INCREMENT à 1)
        Schema::disableForeignKeyConstraints();
        DB::table('monnaies')->truncate();
        Schema::enableForeignKeyConstraints();

        // Récupération dynamique du super-admin
        $superAdminId = DB::table('users')
            ->where('email', 'superadmin@test.com')
            ->value('id');

        if (!$superAdminId) {
            $this->command->warn('⚠️ superadmin@test.com introuvable — monn_saisi_par = 0');
            $superAdminId = '0';
        }

        $now = now();

        DB::table('monnaies')->insert([
            ['id' => 1,  'monn_lib' => 'Ouguiya',         'monn_sym' => 'MRU', 'monn_code' => 'MRU', 'monn_active' => '1', 'monn_saisi_par' => $superAdminId, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2,  'monn_lib' => 'Ouguiya MRO',     'monn_sym' => 'MRO', 'monn_code' => 'MRO', 'monn_active' => '0', 'monn_saisi_par' => $superAdminId, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 3,  'monn_lib' => 'Euro',            'monn_sym' => '€',   'monn_code' => 'EUR', 'monn_active' => '0', 'monn_saisi_par' => $superAdminId, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 4,  'monn_lib' => 'Dollar US',       'monn_sym' => '$',   'monn_code' => 'USD', 'monn_active' => '0', 'monn_saisi_par' => $superAdminId, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 5,  'monn_lib' => 'Franc CFA',       'monn_sym' => 'FCFA','monn_code' => 'FCFA','monn_active' => '0', 'monn_saisi_par' => $superAdminId, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 6,  'monn_lib' => 'Dirham marocain', 'monn_sym' => 'MAD', 'monn_code' => 'MAD', 'monn_active' => '0', 'monn_saisi_par' => $superAdminId, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 7,  'monn_lib' => 'Dinar algérien',  'monn_sym' => 'DZD', 'monn_code' => 'DZD', 'monn_active' => '0', 'monn_saisi_par' => $superAdminId, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 8,  'monn_lib' => 'Dinar tunisien',  'monn_sym' => 'TND', 'monn_code' => 'TND', 'monn_active' => '0', 'monn_saisi_par' => $superAdminId, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 9,  'monn_lib' => 'Dollar CA',       'monn_sym' => '$',   'monn_code' => 'CAD', 'monn_active' => '0', 'monn_saisi_par' => $superAdminId, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 10, 'monn_lib' => 'الريال السعودي',  'monn_sym' => 'الريال السعودي', 'monn_code' => 'الريال السعودي', 'monn_active' => '0', 'monn_saisi_par' => $superAdminId, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 11, 'monn_lib' => 'درهم إماراتي',    'monn_sym' => 'درهم إماراتي',   'monn_code' => 'درهم إماراتي',   'monn_active' => '0', 'monn_saisi_par' => $superAdminId, 'created_at' => $now, 'updated_at' => $now],
        ]);

        $this->command->info('✅ Monnaies insérées : 11');
    }
}