<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModelHasRolesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('model_has_roles')->truncate();

        $users = DB::table('users')->pluck('id', 'email');
        $roles = DB::table('roles')->pluck('id', 'name');

        if ($users->isEmpty() || $roles->isEmpty()) {
            $this->command->error('❌ Lance UsersSeeder et RolesSeeder avant ModelHasRolesSeeder.');
            return;
        }

        $modelType = 'App\\Models\\User';

        $data = [
            [
                'role_id'    => $roles['admin'],
                'model_type' => $modelType,
                'model_id'   => $users['admin@test.com'],
            ],
            [
                'role_id'    => $roles['super-admin'],
                'model_type' => $modelType,
                'model_id'   => $users['superadmin@test.com'],
            ],
        ];

        DB::table('model_has_roles')->insert($data);

        $this->command->info('✅ model_has_roles insérés : ' . count($data));
    }
}