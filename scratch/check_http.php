<?php
$landing = file_get_contents('http://localhost:8000');
echo "Landing has logo.png: " . (str_contains($landing, 'logo.png') ? "YES" : "NO") . "\n";
echo "Landing has 'Apa Itu SIPEDES': " . (str_contains($landing, 'Apa Itu') && str_contains($landing, 'SIPEDES') ? "YES" : "NO") . "\n";
echo "Landing has 'Rombiyah': " . (str_contains($landing, 'Rombiyah') ? "FOUND_OLD" : "CLEAN") . "\n";
echo "Landing has 'Rombiya Barat': " . (str_contains($landing, 'Rombiya Barat') ? "YES" : "NO") . "\n";

$login = file_get_contents('http://localhost:8000/login');
echo "Login has logo.png: " . (str_contains($login, 'logo.png') ? "YES" : "NO") . "\n";
echo "Login has 'Rombiya Barat': " . (str_contains($login, 'Rombiya Barat') ? "YES" : "NO") . "\n";

$admin = file_get_contents('http://localhost:8000/admin/login');
echo "Admin login has logo.png: " . (str_contains($admin, 'logo.png') ? "YES" : "NO") . "\n";
echo "Admin login has 'Rombiya Barat': " . (str_contains($admin, 'Rombiya Barat') ? "YES" : "NO") . "\n";
