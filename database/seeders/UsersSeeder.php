<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('model_has_roles')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::table('users')->truncate();
        Schema::enableForeignKeyConstraints();

        $now = now();

        DB::table('users')->insert([
            [
                'id'                => 1,
                'name'              => 'admin',
                'email'             => 'admin@test.com',
                'email_verified_at' => $now,
                'password'          => Hash::make('password'),
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
            [
                'id'                => 2,
                'name'              => 'superadmin',
                'email'             => 'superadmin@test.com',
                'email_verified_at' => $now,
                'password'          => Hash::make('password'),
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
        ]);

        $this->command->info('✅ Users insérés : 2 (password = "password")');
    }
}