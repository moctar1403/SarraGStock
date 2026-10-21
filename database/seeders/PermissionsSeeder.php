<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Vider les tables pivots qui référencent permissions
        Schema::disableForeignKeyConstraints();
        DB::table('model_has_permissions')->truncate();
        DB::table('role_has_permissions')->truncate();
        DB::table('permissions')->truncate();
        Schema::enableForeignKeyConstraints();

        $permissions = [
            // Rôles & permissions
            'create role', 'view role', 'update role', 'delete role',
            'create permission', 'view permission', 'update permission', 'delete permission',
            // Catégories
            'create category', 'view category', 'update category', 'delete category',
            // Users
            'create user', 'view user', 'update user', 'delete user',
            // Articles
            'create article', 'view article', 'update article', 'delete article',
            // Ventes
            'create vente', 'view vente', 'update vente', 'delete vente',
            // Entrées
            'create entree', 'view entree', 'update entree', 'delete entree',
            // Sorties
            'create sortie', 'view sortie', 'update sortie', 'delete sortie',
            // Clients
            'create client', 'view client', 'update client', 'delete client',
            // Fournisseurs
            'create fournisseur', 'view fournisseur', 'update fournisseur', 'delete fournisseur',
            // Méthodes
            'create methode', 'edit methode', 'view methode', 'update methode', 'delete methode',
            // Transferts
            'create transfert', 'view transert', 'edit transfert', 'delete transfert',
            // Dashboards
            'view dashboard', 'view dashboard3', 'view dashboard4',
            'view dashboard5', 'view dashboard6',
            // Menus / vues
            'view articles', 'view tiers', 'view configurations',
            'view statistiques', 'view operations',
            // Société
            'view societe', 'create societe', 'update societe', 'delete societe',
            // Sauvegarde
            'sauvegarde', 'restauration',
            // Factures
            'view facture', 'facture print', 'facture pdf', 'facture detail',
            // Remises / détails
            'view remise', 'view listedetails', 'create details',
            // Inventaire / paiements
            'view inventaire', 'view paiement', 'view operations methodes',
            // Monnaies / unités / traces
            'view monnaie', 'create monnaie', 'view unite', 'view traces', 'config stock',
            // Menus principaux
            'menu articles', 'menu tiers', 'menu configurations',
            'menu statistiques', 'menu operations',
            // Paiements et suppressions
            'create paiement', 'delete traces', 'update monnaie',
            'delete facture', 'delete paiement', 'delete pfournisseur',
            'delete listedetails', 'delete darticle', 'delete remise',
            'create darticle',
            // Stock & stats
            'view stock', 'view stats_methodes',
            'view paiements_clients', 'view paiements_fournisseurs',
            'view sauvegarde', 'create backup', 'view restauration',
            'view darticle', 'view detail',
            // Ventes / factures
            'liste facture', 'menu ventes',
            'delete methodes', 'view stats_ventes', 'view stats_articles',
            'delete ltransfert', 'See Hello world', 'See Good Bye',
        ];

        $now = now();
        $data = array_map(fn($name) => [
            'name'       => $name,
            'guard_name' => 'web',
            'created_at' => $now,
            'updated_at' => $now,
        ], $permissions);

        DB::table('permissions')->insert($data);

        $this->command->info('✅ Permissions insérées : ' . count($data));
    }
}