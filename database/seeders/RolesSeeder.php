<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('model_has_roles')->truncate();
        DB::table('role_has_permissions')->truncate();
        DB::table('roles')->truncate();
        Schema::enableForeignKeyConstraints();

        $now = now();

        DB::table('roles')->insert([
            ['name' => 'super-admin',           'guard_name' => 'web', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'admin',                 'guard_name' => 'web', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Manager de ventes',     'guard_name' => 'web', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Vendeur',               'guard_name' => 'web', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Comptable',             'guard_name' => 'web', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Responsable de stock',  'guard_name' => 'web', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Directeur observateur', 'guard_name' => 'web', 'created_at' => $now, 'updated_at' => $now],
        ]);

        $this->command->info('✅ Roles insérés : 7');
    }
}