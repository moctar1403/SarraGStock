<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
//use Faker as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //$faker = Faker::create();
        //creation de 50 aclients
        for ($i=1; $i <11 ; $i++) { 
            DB::table('clients')->insert([
                'cli_nom' => fake()->name(),
                'cli_societe' => Str::random(8),
                'cli_civilite' => Str::random(3),
                'cli_tel' => '22113344',
                'cli_adresse' => fake()->address(),
                'cli_email' => Str::random(5).'@example.com',  
                'cli_observations' => Str::random(3),
                'cli_saisi_par' => '1',
                //'email' => Str::random(10).'@example.com',           
                //'password' => Hash::make('password'),
            ]);
         }
        //creation de 50 articles
        for ($i=1; $i <11 ; $i++) { 
            DB::table('articles')->insert([
                'ar_reference' => Str::random(6),
                'ar_lib' => 'Article '.$i,
                'ar_description' => Str::random(10),
                'ar_codebarre' => Str::random(10),
                'ar_qte' => random_int(10,100),
                'ar_qte_mini' => random_int(8,10),
                'ar_prix_achat' => random_int(10,20),
                'ar_prix_vente' => random_int(25,50),
                'ar_saisi_par' => '1',
                //'email' => Str::random(10).'@example.com',           
                //'password' => Hash::make('password'),
            ]);
        }
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
