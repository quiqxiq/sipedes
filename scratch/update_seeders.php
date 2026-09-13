<?php
foreach (glob(__DIR__ . '/../database/seeders/*.php') as $file) {
    $c = file_get_contents($file);
    if (str_contains($c, 'Rombiyah')) {
        file_put_contents($file, str_replace('Rombiyah', 'Rombiya', $c));
        echo "Updated seeder: " . basename($file) . "\n";
    }
}
