<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

echo "=== TEST RESTAURATION ===\n\n";

// 1. Lister les backups disponibles
$files = Storage::files('backups');
$backupFiles = array_filter($files, function($file) {
    return str_ends_with($file, '.sql');
});

if (empty($backupFiles)) {
    echo "❌ Aucun fichier de backup trouvé\n";
    exit;
}

// 2. Prendre le dernier backup
$latestBackup = $backupFiles[count($backupFiles) - 1];
$backupPath = storage_path('app/' . $latestBackup);
echo "📁 Backup trouvé: " . basename($latestBackup) . "\n";
echo "📊 Taille: " . filesize($backupPath) . " bytes\n";

// 3. Vérifier le contenu du backup
$content = file_get_contents($backupPath);
$hasCreateTable = preg_match('/CREATE TABLE/i', $content);
$hasInsert = preg_match('/INSERT INTO/i', $content);

echo "✓ Contient CREATE TABLE: " . ($hasCreateTable ? 'OUI' : 'NON') . "\n";
echo "✓ Contient INSERT INTO: " . ($hasInsert ? 'OUI' : 'NON') . "\n";
echo "✓ Premières lignes:\n";
echo substr($content, 0, 500) . "\n...\n";

// 4. Ne pas faire la vraie restauration ici (trop dangereux)
echo "\n⚠️ Pour tester la restauration, utilise l'interface web\n";
echo "   POST /restore avec le fichier: " . basename($latestBackup) . "\n";