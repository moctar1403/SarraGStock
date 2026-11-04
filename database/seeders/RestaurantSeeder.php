<?php

namespace Database\Seeders;

use App\Models\Categorie;
use Illuminate\Database\Seeder;

class RestaurantSeeder extends Seeder
{
        public function run(): void
    {
        // Création des catégories verrouillées
        Categorie::firstOrCreate(['nom' => 'Plats'], ['est_verrouille' => true]);
        Categorie::firstOrCreate(['nom' => 'Boissons'], ['est_verrouille' => true]);
        Categorie::firstOrCreate(['nom' => 'Desserts'], ['est_verrouille' => true]);
        Categorie::firstOrCreate(['nom' => 'Entrées'], ['est_verrouille' => true]);

        $this->command->info('✅ Catégories de restaurant créées et verrouillées.');
    }
}