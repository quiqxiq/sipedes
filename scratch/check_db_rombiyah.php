<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Check landing HTML line containing Rombiyah
$landing = file_get_contents('http://localhost:8000');
$lines = explode("\n", $landing);
foreach ($lines as $i => $line) {
    if (str_contains($line, 'Rombiyah')) {
        echo "Line " . ($i+1) . ": " . trim($line) . "\n";
    }
}
