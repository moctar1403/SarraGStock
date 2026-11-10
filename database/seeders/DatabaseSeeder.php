<?php

namespace Database\Seeders;
use Database\Seeders\MethodevsSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        // =====================
        // 1) VIDAGE DES TABLES
        // =====================
        // Tables enfants
        DB::table('cities')->truncate();
        DB::table('entrstocks')->truncate();
        DB::table('sortstocks')->truncate();
        DB::table('commandes')->truncate();
        DB::table('darticles')->truncate();
        DB::table('remises')->truncate();
        DB::table('listedetails')->truncate();
        DB::table('payements')->truncate();
        DB::table('payfournisseurs')->truncate();
        DB::table('operats')->truncate();
        DB::table('transferts')->truncate();
        DB::table('ventes')->truncate();
        DB::table('caisses')->truncate();
        
        // Tables mères niveau 1
        DB::table('factures')->truncate();
        
        // Tables mères niveau 2
        DB::table('societes')->truncate();
        DB::table('states')->truncate();
        DB::table('traces')->truncate();
        DB::table('tvas')->truncate();
        DB::table('clients')->truncate();
        DB::table('fournisseurs')->truncate();
        DB::table('articles')->truncate();
        DB::table('categories')->truncate();
        
        // Table methodes (référentiel)
        DB::table('methodes')->truncate();
        DB::table('methodevs')->truncate();
        DB::table('unites')->truncate();
        DB::table('sunites')->truncate();
        
        // Charges (NOUVEAU)
        DB::table('charges')->truncate();
        
        // Auth (⚠️ les pivots d'abord !)
        DB::table('model_has_permissions')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('role_has_permissions')->truncate();
        DB::table('permissions')->truncate();
        DB::table('roles')->truncate();
        DB::table('users')->truncate();
        DB::table('sessions')->truncate();
        
        Schema::enableForeignKeyConstraints();
        
        // Appel des seeders
        $this->call([
            // Auth
            PermissionsSeeder::class,
            RolesSeeder::class,
            UsersSeeder::class,
            ModelHasRolesSeeder::class,
            RoleHasPermissionsSeeder::class,  
            MethodesSeeder::class,
            MethodevsSeeder::class,
            MonnaiesSeeder::class,
            UnitesSeeder::class,
            SunitesSeeder::class,
            RestaurantSeeder::class,
        ]);
    }
}