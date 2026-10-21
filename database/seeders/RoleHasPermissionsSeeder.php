<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RoleHasPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('role_has_permissions')->truncate();
        Schema::enableForeignKeyConstraints();

        $roles = DB::table('roles')->pluck('id', 'name');
        $perms = DB::table('permissions')->pluck('id', 'name');

        if ($roles->isEmpty() || $perms->isEmpty()) {
            $this->command->error('❌ Lance RolesSeeder et PermissionsSeeder avant.');
            return;
        }

        $rows = [];

        // ============================================
        // super-admin : TOUTES les permissions
        // ============================================
        foreach ($perms as $permId) {
            $rows[] = ['permission_id' => $permId, 'role_id' => $roles['super-admin']];
        }

        // ============================================
        // admin : quasi super-admin
        // (tout sauf "delete role" et "delete permission")
        // ============================================
        $excludedFromAdmin = [
            'delete role',
            'delete permission',
        ];

        foreach ($perms as $permName => $permId) {
            if (!in_array($permName, $excludedFromAdmin, true)) {
                $rows[] = ['permission_id' => $permId, 'role_id' => $roles['admin']];
            }
        }

        // ============================================
        // Manager de ventes
        // ============================================
        $managerPerms = [
            'view role', 'view permission', 'view category', 'view user',
            'view article', 'view vente', 'view entree', 'view sortie',
            'view client', 'view fournisseur', 'view transert',
            'view dashboard', 'view dashboard3', 'view dashboard4',
            'view dashboard5', 'view dashboard6',
            'view articles', 'view tiers', 'view configurations',
            'view statistiques', 'view operations', 'view societe',
            'view facture', 'view remise', 'view listedetails',
            'view inventaire', 'view paiement', 'view monnaie',
            'view unite', 'view traces',
            'menu articles', 'menu tiers', 'menu configurations',
            'menu statistiques', 'menu operations',
        ];
        foreach ($managerPerms as $name) {
            if (isset($perms[$name])) {
                $rows[] = ['permission_id' => $perms[$name], 'role_id' => $roles['Manager de ventes']];
            }
        }

        // ============================================
        // Comptable
        // ============================================
        if (isset($perms['view dashboard'])) {
            $rows[] = ['permission_id' => $perms['view dashboard'], 'role_id' => $roles['Comptable']];
        }

        // ============================================
        // Directeur observateur
        // ============================================
        $directeurPerms = [
            'view role', 'view permission', 'view category', 'view user',
            'create article', 'view article', 'view vente', 'view entree',
            'view sortie', 'view client', 'view fournisseur', 'view methode',
            'view transert', 'view dashboard', 'view dashboard3',
            'view dashboard4', 'view dashboard5', 'view dashboard6',
            'view articles', 'view tiers', 'view configurations',
            'view statistiques', 'view operations', 'view societe',
            'view facture', 'view remise', 'view listedetails',
            'view inventaire', 'view paiement', 'view operations methodes',
            'view monnaie', 'view unite', 'view traces',
            'menu articles', 'menu tiers', 'menu configurations',
            'menu statistiques', 'menu operations',
        ];
        foreach ($directeurPerms as $name) {
            if (isset($perms[$name])) {
                $rows[] = ['permission_id' => $perms[$name], 'role_id' => $roles['Directeur observateur']];
            }
        }

        // ============================================
        // Dédoublonnage (sécurité)
        // ============================================
        $unique = [];
        $seen = [];
        foreach ($rows as $row) {
            $key = $row['role_id'] . '-' . $row['permission_id'];
            if (!isset($seen[$key])) {
                $unique[] = $row;
                $seen[$key] = true;
            }
        }

        // ============================================
        // Insertion en masse
        // ============================================
        DB::table('role_has_permissions')->insert($unique);

        // Vider le cache Spatie
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $this->command->info('✅ role_has_permissions insérés : ' . count($unique));
    }
}