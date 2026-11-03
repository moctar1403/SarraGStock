<?php

namespace Database\Seeders;

use App\Models\Categorie;
use App\Models\Article;
use Illuminate\Database\Seeder;

class RestaurantSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Créer les catégories
        $catPlats = Categorie::create(['nom' => 'Plats']);
        $catBoissons = Categorie::create(['nom' => 'Boissons']);
        $catDesserts = Categorie::create(['nom' => 'Desserts']);

        // 2. Créer des articles (Plats)
        Article::create([
            'ar_reference' => 'PLAT-01',
            'ar_lib' => 'Poulet Yassa',
            'ar_description' => 'Poulet mariné au citron et oignons',
            'ar_codebarre' => '111111',
            'ar_qte' => 9999,
            'ar_qte_mini' => 0,
            'ar_unite' => 1,
            'ar_prix_achat' => 1000,
            'ar_prix_vente' => 2500,
            'ar_saisi_par' => 1,
            'categorie_id' => $catPlats->id,
            'gerer_stock' => false, // Pas de gestion de stock pour un plat
        ]);

        Article::create([
            'ar_reference' => 'PLAT-02',
            'ar_lib' => 'Thieboudienne',
            'ar_description' => 'Riz au poisson',
            'ar_codebarre' => '222222',
            'ar_qte' => 9999,
            'ar_qte_mini' => 0,
            'ar_unite' => 1,
            'ar_prix_achat' => 1200,
            'ar_prix_vente' => 3000,
            'ar_saisi_par' => 1,
            'categorie_id' => $catPlats->id,
            'gerer_stock' => false,
        ]);

        // 3. Créer des articles (Boissons avec stock)
        Article::create([
            'ar_reference' => 'BOIS-01',
            'ar_lib' => 'Coca Cola',
            'ar_description' => 'Canette 33cl',
            'ar_codebarre' => '333333',
            'ar_qte' => 100, // Stock réel
            'ar_qte_mini' => 10,
            'ar_unite' => 1,
            'ar_prix_achat' => 200,
            'ar_prix_vente' => 500,
            'ar_saisi_par' => 1,
            'categorie_id' => $catBoissons->id,
            'gerer_stock' => true, // Gestion de stock activée
        ]);

        Article::create([
            'ar_reference' => 'BOIS-02',
            'ar_lib' => 'Jus de Bissap',
            'ar_description' => 'Jus frais maison',
            'ar_codebarre' => '444444',
            'ar_qte' => 9999,
            'ar_qte_mini' => 0,
            'ar_unite' => 1,
            'ar_prix_achat' => 300,
            'ar_prix_vente' => 1000,
            'ar_saisi_par' => 1,
            'categorie_id' => $catBoissons->id,
            'gerer_stock' => false, // Jus maison (pas de stock)
        ]);

        // 4. Créer des articles (Desserts)
        Article::create([
            'ar_reference' => 'DES-01',
            'ar_lib' => 'Tiramisu',
            'ar_description' => 'Dessert italien',
            'ar_codebarre' => '555555',
            'ar_qte' => 9999,
            'ar_qte_mini' => 0,
            'ar_unite' => 1,
            'ar_prix_achat' => 500,
            'ar_prix_vente' => 1500,
            'ar_saisi_par' => 1,
            'categorie_id' => $catDesserts->id,
            'gerer_stock' => false,
        ]);
    }
}