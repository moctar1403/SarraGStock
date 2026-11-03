<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ResetDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        // 1. Vider les tables enfants (dépendantes)
        $tablesEnfants = [
            'remises', 'operats', 'sortstocks', 'entrstocks', 
            'payements', 'remboursements', 'payfournisseurs',
            'ventes', 'caisses', 'darticles', 'listedetails'
        ];

        foreach ($tablesEnfants as $table) {
            if (Schema::hasTable($table)) {
                DB::table($table)->truncate();
                $this->command->info("Table {$table} vidée.");
            }
        }

        // 2. Vider les tables mères
        $tablesMeres = [
            'factures', 'articles', 'categories', 'clients', 'fournisseurs'
        ];

        foreach ($tablesMeres as $table) {
            if (Schema::hasTable($table)) {
                DB::table($table)->truncate();
                $this->command->info("Table {$table} vidée.");
            }
        }

        // 3. Vider les tables de configuration (SANS monnaies)
        $tablesConfig = [
            'methodes', 'societes', 'parametres', 'tvas'
        ];

        foreach ($tablesConfig as $table) {
            if (Schema::hasTable($table)) {
                DB::table($table)->truncate();
                $this->command->info("Table {$table} vidée.");
            }
        }

        Schema::enableForeignKeyConstraints();

        $this->command->info('✅ Base de données réinitialisée avec succès !');
    }
}