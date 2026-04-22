<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Storage;

$controller = new App\Http\Controllers\BackupController();

echo "=== TEST SAUVEGARDE ===\n\n";

// Test 1: Vérifier la connexion BDD
try {
    $db = config('database.connections.mysql');
    echo "✓ Connexion BDD configurée: {$db['database']}\n";
    echo "  Host: {$db['host']}, User: {$db['username']}\n";
} catch (Exception $e) {
    echo "✗ Erreur config BDD: " . $e->getMessage() . "\n";
}

// Test 2: Vérifier le dossier de backup
$backupPath = storage_path('app/backups');
if (!is_dir($backupPath)) {
    mkdir($backupPath, 0777, true);
    echo "✓ Dossier backup créé: $backupPath\n";
} else {
    echo "✓ Dossier backup existe: $backupPath\n";
}

// Test 3: Tenter la sauvegarde
echo "\n--- Lancement de la sauvegarde ---\n";
try {
    $response = $controller->backup();
    echo "✓ Sauvegarde exécutée avec succès!\n";
    
    // Lister les fichiers de backup
    $files = Storage::files('backups');
    if (!empty($files)) {
        echo "\n--- Fichiers de backup ---\n";
        foreach ($files as $file) {
            $size = Storage::size($file);
            $date = date('Y-m-d H:i:s', Storage::lastModified($file));
            echo "• $file ($size bytes) - $date\n";
        }
    } else {
        echo "⚠ Aucun fichier de backup trouvé dans storage/app/backups\n";
    }
} catch (Exception $e) {
    echo "✗ Erreur sauvegarde: " . $e->getMessage() . "\n";
    echo "  Fichier: " . $e->getFile() . " ligne " . $e->getLine() . "\n";
}