<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

echo "Updating database records from Rombiyah to Rombiya...\n";

foreach (App\Models\JenisSurat::all() as $m) {
    $m->deskripsi = str_replace('Rombiyah', 'Rombiya', $m->deskripsi ?? '');
    if (is_array($m->syarat)) {
        $encoded = json_encode($m->syarat);
        $encoded = str_replace('Rombiyah', 'Rombiya', $encoded);
        $m->syarat = json_decode($encoded, true);
    }
    $m->save();
}

foreach (App\Models\Berita::all() as $m) {
    $m->judul = str_replace('Rombiyah', 'Rombiya', $m->judul);
    $m->ringkasan = str_replace('Rombiyah', 'Rombiya', $m->ringkasan);
    $m->konten = str_replace('Rombiyah', 'Rombiya', $m->konten);
    $m->save();
}

foreach (App\Models\ProgramBantuan::all() as $m) {
    $m->nama_program = str_replace('Rombiyah', 'Rombiya', $m->nama_program);
    $m->sumber_dana = str_replace('Rombiyah', 'Rombiya', $m->sumber_dana);
    $m->kriteria_penerima = str_replace('Rombiyah', 'Rombiya', $m->kriteria_penerima);
    $m->keterangan = str_replace('Rombiyah', 'Rombiya', $m->keterangan ?? '');
    $m->save();
}

foreach (App\Models\PerangkatDesa::all() as $m) {
    $m->wilayah_tugas = str_replace('Rombiyah', 'Rombiya', $m->wilayah_tugas);
    $m->save();
}

foreach (App\Models\User::all() as $m) {
    $m->name = str_replace('Rombiyah', 'Rombiya', $m->name);
    $m->alamat = str_replace('Rombiyah', 'Rombiya', $m->alamat);
    $m->save();
}

$profil = App\Models\ProfilDesa::first();
if ($profil) {
    $profil->nama_desa = 'Rombiya Barat';
    $profil->sejarah = str_replace('Rombiyah', 'Rombiya', $profil->sejarah);
    $profil->visi_misi = str_replace('Rombiyah', 'Rombiya', $profil->visi_misi);
    if (is_array($profil->kontak)) {
        $encoded = json_encode($profil->kontak);
        $encoded = str_replace('Rombiyah', 'Rombiya', $encoded);
        $profil->kontak = json_decode($encoded, true);
    }
    $profil->save();
}

echo "All Eloquent models updated successfully.\n";

echo "Database updated successfully.\n";
