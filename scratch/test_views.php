<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$profil = App\Models\ProfilDesa::first();
echo "Nama Desa: " . $profil->nama_desa . "\n";

$landingHtml = view('warga.landing', [
    'profil' => $profil,
    'beritaTerbaru' => App\Models\Berita::take(3)->get(),
    'jenisSurat' => App\Models\JenisSurat::all(),
    'perangkatDesa' => App\Models\PerangkatDesa::all(),
    'totalSuratDisetujui' => 15,
    'totalPengaduanSelesai' => 8,
])->render();

echo "Landing page rendered successfully (" . strlen($landingHtml) . " bytes)\n";

$loginHtml = view('warga.auth.login')->render();
echo "Login page rendered successfully (" . strlen($loginHtml) . " bytes)\n";

$registerHtml = view('warga.auth.register')->render();
echo "Register page rendered successfully (" . strlen($registerHtml) . " bytes)\n";

$pengaduanHtml = view('warga.pengaduan.create')->render();
echo "Pengaduan create rendered successfully (" . strlen($pengaduanHtml) . " bytes)\n";
