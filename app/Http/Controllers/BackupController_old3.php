<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;

class BackupController extends Controller
{
    /**
     * Sauvegarde intelligente - choisit la meilleure méthode
     */
    public function backup()
    {
        // 1. Essayer d'abord avec mysqldump (plus rapide et fiable)
        if ($this->canUseMysqldump()) {
            $result = $this->backupWithMysqldump();
            if ($result['success']) {
                return $result['response'];
            }
            // Si échec, logger et passer à la méthode PHP
            \Log::warning('Mysqldump failed, falling back to PHP method: ' . $result['error']);
        }
        
        // 2. Fallback : méthode PHP pure
        return $this->backupWithPHP();
    }
    
    /**
     * Vérifie si mysqldump est disponible
     */
    private function canUseMysqldump()
    {
        // Vérifier si les fonctions system sont autorisées
        if (!function_exists('exec') || !function_exists('shell_exec')) {
            return false;
        }
        
        // Vérifier si on est en environnement de dev (optionnel)
        if (app()->environment('production') && $this->isSharedHosting()) {
            return false;
        }
        
        return true;
    }
    
    /**
     * Détection approximative de l'hébergement mutualisé
     */
    private function isSharedHosting()
    {
        // Indices d'hébergement mutualisé
        $indicators = ['ovh', 'hostinger', 'infomaniak', 'planethoster', 'alwaysdata'];
        $host = gethostname();
        
        foreach ($indicators as $indicator) {
            if (strpos($host, $indicator) !== false) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Sauvegarde avec mysqldump (méthode rapide)
     */
    private function backupWithMysqldump()
    {
        try {
            $db = config('database.connections.mysql');
            
            // Détection auto du chemin mysqldump
            $mysqldump = $this->findMysqldump();
            
            if (!$mysqldump) {
                return ['success' => false, 'error' => 'mysqldump not found'];
            }
            
            $filename = 'backup-' . date('Y-m-d-H-i-s') . '.sql';
            $path = storage_path('app/backups/' . $filename);
            
            if (!is_dir(dirname($path))) {
                mkdir(dirname($path), 0777, true);
            }
            
            $command = sprintf(
                '"%s" --user="%s" --password="%s" --host="%s" --port="%s" --single-transaction --routines --triggers "%s" > "%s"',
                $mysqldump,
                $db['username'],
                $db['password'],
                $db['host'],
                $db['port'],
                $db['database'],
                $path
            );
            
            exec($command . ' 2>&1', $output, $returnCode);
            
            if ($returnCode !== 0) {
                return ['success' => false, 'error' => implode("\n", $output)];
            }
            
            return [
                'success' => true,
                'response' => response()->download($path)->deleteFileAfterSend(true)
            ];
            
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
    
    /**
     * Récupère les noms des tables de manière universelle
     */
    private function getTableNames()
    {
        $tables = DB::select('SHOW TABLES');
        $tableNames = [];
        
        foreach ($tables as $table) {
            // Méthode universelle : convertir en tableau et prendre la première valeur
            $array = (array) $table;
            $tableNames[] = reset($array);
        }
        
        return $tableNames;
    }
    
    /**
     * Sauvegarde avec PHP pur (méthode lente mais compatible)
     */
    private function backupWithPHP()
    {
        try {
            $tableNames = $this->getTableNames();
            
            $sql = "-- Backup généré le " . date('Y-m-d H:i:s') . "\n";
            $sql .= "-- Méthode: PHP pure (compatible hébergement)\n";
            $sql .= "-- Base: " . env('DB_DATABASE') . "\n\n";
            $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";
            
            $totalSize = 0;
            
            foreach ($tableNames as $tableName) {
                $sql .= $this->getTableStructurePHP($tableName);
                $dataSQL = $this->getTableDataPHP($tableName);
                $sql .= $dataSQL;
                $totalSize += strlen($dataSQL);
                
                // Si le fichier devient trop gros, on sauvegarde en morceaux
                if ($totalSize > 50 * 1024 * 1024) { // 50MB
                    $sql .= "\n-- Attention: Backup tronqué car fichier trop gros\n";
                    break;
                }
            }
            
            $sql .= "\nSET FOREIGN_KEY_CHECKS=1;\n";
            
            $filename = 'backup-php-' . date('Y-m-d-H-i-s') . '.sql';
            $path = 'backups/' . $filename;
            
            Storage::put($path, $sql);
            
            return response()->download(storage_path('app/' . $path))->deleteFileAfterSend(true);
            
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('danger', 'Erreur sauvegarde: ' . $e->getMessage());
        }
    }
    
    /**
     * Structure d'une table (version PHP)
     */
    private function getTableStructurePHP($tableName)
    {
        $createTable = DB::select("SHOW CREATE TABLE `$tableName`");
        $sql = "\n-- Structure de la table `$tableName`\n";
        $sql .= "DROP TABLE IF EXISTS `$tableName`;\n";
        $sql .= $createTable[0]->{'Create Table'} . ";\n\n";
        
        return $sql;
    }
    
    /**
     * Données d'une table (version PHP)
     */
    private function getTableDataPHP($tableName)
    {
        $rows = DB::table($tableName)->get();
        
        if ($rows->isEmpty()) {
            return "";
        }
        
        $sql = "\n-- Données de la table `$tableName`\n";
        $batchSize = 100;
        $counter = 0;
        
        foreach ($rows as $row) {
            $columns = [];
            $values = [];
            
            foreach ((array)$row as $key => $value) {
                $columns[] = "`$key`";
                if ($value === null) {
                    $values[] = "NULL";
                } else {
                    $values[] = DB::connection()->getPdo()->quote($value);
                }
            }
            
            $sql .= "INSERT INTO `$tableName` (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $values) . ");\n";
            $counter++;
            
            // Regrouper par lots de 100 pour lisibilité
            if ($counter % $batchSize === 0) {
                $sql .= "\n";
            }
        }
        
        $sql .= "\n";
        
        return $sql;
    }
    
    /**
     * Détection du chemin mysqldump (Windows/Linux)
     */
    private function findMysqldump()
    {
        // Linux/Unix
        $linuxPaths = [
            '/usr/bin/mysqldump',
            '/usr/local/bin/mysqldump',
            '/opt/lampp/bin/mysqldump',
        ];
        
        foreach ($linuxPaths as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }
        
        // Windows (WAMP/XAMPP/MariaDB)
        $windowsPaths = [
            realpath(dirname(base_path(), 2) . '/mariadb/bin/mysqldump.exe'),
            'C:\\wamp64\\bin\\mysql\\mysql8.0.31\\bin\\mysqldump.exe',
            'C:\\wamp64\\bin\\mysql\\mysql5.7.36\\bin\\mysqldump.exe',
            'C:\\xampp\\mysql\\bin\\mysqldump.exe',
        ];
        
        foreach ($windowsPaths as $path) {
            if ($path && file_exists($path)) {
                return $path;
            }
        }
        
        // Tester dans le PATH
        $test = @shell_exec('where mysqldump 2>nul');
        if (!$test) {
            $test = @shell_exec('which mysqldump 2>/dev/null');
        }
        if ($test && trim($test)) {
            return trim($test);
        }
        
        return null;
    }
    
    /**
     * Restauration intelligente
     */
    public function restore(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|file|mimes:sql,txt|max:204800' // 200MB max
        ]);
        
        // Essayer d'abord avec mysql command si disponible
        if ($this->canUseMysql()) {
            $result = $this->restoreWithMysql($request);
            if ($result['success']) {
                return redirect()->route('dashboard')->with('success', 'Base restaurée avec succès (méthode rapide)');
            }
        }
        
        // Fallback: méthode PHP
        return $this->restoreWithPHP($request);
    }
    
    /**
     * Restauration avec commande mysql (rapide)
     */
    private function restoreWithMysql($request)
    {
        try {
            $db = config('database.connections.mysql');
            $mysql = $this->findMysql();
            $file = $request->file('backup_file');
            
            if (!$mysql) {
                return ['success' => false];
            }
            
            $command = sprintf(
                '"%s" --user="%s" --password="%s" --host="%s" --port="%s" "%s" < "%s"',
                $mysql,
                $db['username'],
                $db['password'],
                $db['host'],
                $db['port'],
                $db['database'],
                $file->getRealPath()
            );
            
            exec($command . ' 2>&1', $output, $returnCode);
            
            return ['success' => $returnCode === 0];
            
        } catch (\Exception $e) {
            return ['success' => false];
        }
    }
    
    /**
     * Restauration avec PHP pur (lent mais compatible)
     */
    private function restoreWithPHP($request)
    {
        try {
            $file = $request->file('backup_file');
            $sql = file_get_contents($file->getRealPath());
            
            // Désactiver les contraintes
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            
            // Supprimer les tables existantes - Version corrigée
            $tableNames = $this->getTableNames();
            foreach ($tableNames as $tableName) {
                DB::statement("DROP TABLE IF EXISTS `$tableName`");
            }
            
            // Exécuter le SQL par lots
            $statements = array_filter(array_map('trim', explode(';', $sql)));
            
            foreach ($statements as $statement) {
                if (!empty($statement)) {
                    try {
                        DB::statement($statement);
                    } catch (\Exception $e) {
                        // Ignorer les erreurs de doublons et de tables existantes
                        if (strpos($e->getMessage(), 'Duplicate') === false && 
                            strpos($e->getMessage(), 'already exists') === false) {
                            // Pour les autres erreurs, on log mais on continue
                            \Log::warning('SQL Statement failed: ' . $e->getMessage() . ' in statement: ' . substr($statement, 0, 200));
                        }
                    }
                }
            }
            
            // Réactiver les contraintes
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
            
            return redirect()->route('dashboard')->with('success', 'Base restaurée avec succès');
            
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('danger', 'Erreur restauration: ' . $e->getMessage());
        }
    }
    
    /**
     * Vérifie si mysql est disponible
     */
    private function canUseMysql()
    {
        return $this->canUseMysqldump() && $this->findMysql();
    }
    
    /**
     * Détection du chemin mysql (Windows/Linux)
     */
    private function findMysql()
    {
        // Linux/Unix
        $linuxPaths = [
            '/usr/bin/mysql',
            '/usr/local/bin/mysql',
            '/opt/lampp/bin/mysql',
        ];
        
        foreach ($linuxPaths as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }
        
        // Windows (WAMP/XAMPP/MariaDB)
        $windowsPaths = [
            realpath(dirname(base_path(), 2) . '/mariadb/bin/mysql.exe'),
            'C:\\wamp64\\bin\\mysql\\mysql8.0.31\\bin\\mysql.exe',
            'C:\\wamp64\\bin\\mysql\\mysql5.7.36\\bin\\mysql.exe',
            'C:\\xampp\\mysql\\bin\\mysql.exe',
        ];
        
        foreach ($windowsPaths as $path) {
            if ($path && file_exists($path)) {
                return $path;
            }
        }
        
        // Tester dans le PATH
        $test = @shell_exec('where mysql 2>nul');
        if (!$test) {
            $test = @shell_exec('which mysql 2>/dev/null');
        }
        if ($test && trim($test)) {
            return trim($test);
        }
        
        return null;
    }
}