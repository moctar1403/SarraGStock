<?php

use Illuminate\Contracts\Console\Kernel;

require_once __DIR__ . '/../bootstrap/app.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

try {
    $kernel->call('route:clear');
    $kernel->call('view:clear');
    $kernel->call('config:clear');
    $kernel->call('cache:clear');
    echo "All caches cleared successfully.";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}