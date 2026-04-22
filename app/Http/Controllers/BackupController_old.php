<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;

class BackupController extends Controller
{
public function backup()
{
    $db = config('database.connections.mysql');

$mysqldump = realpath(dirname(base_path(), 2) . '/mariadb/bin/mysqldump.exe');
if (!$mysqldump) {
    return back()->with('danger', 'mysqldump.exe introuvable');
}
$filename = 'backup-' . date('Y-m-d-H-i-s') . '.sql';
$path = storage_path('app/backups/' . $filename);

if (!is_dir(dirname($path))) {
    mkdir(dirname($path), 0777, true);
}

$command = [
    $mysqldump,
    "--user={$db['username']}",
    "--host={$db['host']}",
    "--port={$db['port']}",
    "--default-character-set=utf8mb4",
    $db['database']
];

$process = new Process($command, base_path());
$process->run();

if (!$process->isSuccessful()) {
    return back()->with('error', $process->getErrorOutput());
}

file_put_contents($path, $process->getOutput());

return response()->download($path)->deleteFileAfterSend(true);

}

public function backup3()
{
    $mysqldump = 'C:\\Users\\PC16\\Desktop\\SarraGstock\\mariadb\\bin\\mysqldump.exe';

    $cmd = "\"$mysqldump\" --version";

    dd(shell_exec($cmd));
}

public function backup2()
{
    dd(shell_exec('whoami'));
    $db = config('database.connections.mysql');
    $filename = 'backup-' . date('Y-m-d-H-i-s') . '.sql';
    $path = storage_path('app/backups/' . $filename);

    if (!is_dir(dirname($path))) {
        mkdir(dirname($path), 0777, true);
    }

    $mysqldump = base_path('mariadb/bin/mysqldump.exe');

    $process = new Process([
        $mysqldump,
        "--user={$db['username']}",
        "--password={$db['password']}",
        "--host={$db['host']}",
        "--port={$db['port']}",
        "--default-character-set=utf8mb4",
        $db['database']
    ]);

    $process->setTimeout(300);
    $process->run();

    if (!$process->isSuccessful()) {
        return back()->with('error', $process->getErrorOutput());
    }

    file_put_contents($path, $process->getOutput());

    return response()->download($path)->deleteFileAfterSend(true);
}


    public function restore2(Request $request)
{
    $request->validate([
        'backup_file' => 'required|file|mimes:sql',
    ]);

    $db = config('database.connections.mysql');
    $path = $request->file('backup_file')->getRealPath();

    // Chemin mysql (adapte si PHPDesktop)
    $mysql = 'mysql';

    // ⚠️ 1) Récupérer toutes les tables existantes
    $tablesProcess = new \Symfony\Component\Process\Process([
        $mysql,
        "--user={$db['username']}",
        "--password={$db['password']}",
        "--host={$db['host']}",
        "--port={$db['port']}",
        "-N", "-e", "SHOW TABLES FROM {$db['database']}"
    ]);

    $tablesProcess->run();
    $tables = array_filter(explode("\n", $tablesProcess->getOutput()));

    // ⚠️ 2) Désactiver les clés étrangères + DROP toutes les tables
    $dropSQL = "SET FOREIGN_KEY_CHECKS=0;\n";
    foreach ($tables as $table) {
        $dropSQL .= "DROP TABLE IF EXISTS `$table`;\n";
    }
    $dropSQL .= "SET FOREIGN_KEY_CHECKS=1;\n";

    // Exécuter le DROP
    $dropProcess = new \Symfony\Component\Process\Process([
        $mysql,
        "--user={$db['username']}",
        "--password={$db['password']}",
        "--host={$db['host']}",
        "--port={$db['port']}",
        $db['database']
    ]);
    $dropProcess->setInput($dropSQL);
    $dropProcess->run();

    if (!$dropProcess->isSuccessful()) {
        return back()->with('error', "Erreur DROP : " . $dropProcess->getErrorOutput());
    }

    // ⚠️ 3) Réimporter la sauvegarde depuis STDIN
    $importProcess = new \Symfony\Component\Process\Process([
        $mysql,
        "--user={$db['username']}",
        "--password={$db['password']}",
        "--host={$db['host']}",
        "--port={$db['port']}",
        $db['database']
    ]);

    $importProcess->setInput(file_get_contents($path));
    $importProcess->run();

    if (!$importProcess->isSuccessful()) {
        return back()->with('error', "Erreur restauration : " . $importProcess->getErrorOutput());
    }

    return back()->with('success', 'Base restaurée avec succès.');
}
public function restore(Request $request)
{
    $request->validate([
        'backup_file' => 'required|file|extensions:sql',
    ]);
    $sql = file_get_contents($request->file('backup_file')->getRealPath());

    $db = config('database.connections.mysql');
    $pdo = new \PDO(
        "mysql:host={$db['host']};port={$db['port']};dbname={$db['database']}",
        $db['username'],
        $db['password'],
        [\PDO::MYSQL_ATTR_MULTI_STATEMENTS => true]
    );

    // Step 1 : désactiver les clés étrangères
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");

    // Step 2 : drop toutes les tables
    $tables = $pdo->query("SHOW TABLES")->fetchAll(\PDO::FETCH_COLUMN);
    foreach ($tables as $table) {
        $pdo->exec("DROP TABLE IF EXISTS `$table`");
    }

    // Step 3 : réactiver les clés
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

    // Step 4 : exécuter le SQL de la sauvegarde
    try {
        $pdo->exec($sql);
    } catch (\PDOException $e) {
        // return back()->with('danger', 'Erreur restauration SQL : ' . $e->getMessage());
        return redirect()->route('dashboard')->with('danger', 'Erreur restauration SQL : ' . $e->getMessage());
    }

    // return back()->with('success', 'Base restaurée avec succès !');
    return redirect()->route('dashboard')->with('success', 'Base restaurée avec succès !');
}


}
