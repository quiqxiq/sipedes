<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\JenisSurat;
use App\Models\Pengaduan;
use App\Models\PerangkatDesa;
use App\Models\PermohonanSurat;
use App\Models\ProfilDesa;
use App\Models\ProgramBantuan;

class LandingController extends Controller
{
    public function index()
    {
        $profil = ProfilDesa::first();
        $jenisSurat = JenisSurat::where('is_active', true)->get();
        $beritaTerbaru = Berita::where('is_published', true)->latest('published_at')->take(3)->get();
        $programBantuan = ProgramBantuan::latest()->take(4)->get();
        $perangkatDesa = PerangkatDesa::where('is_active', true)->orderBy('urutan')->get();
        
        $totalSuratDisetujui = PermohonanSurat::where('status', 'disetujui')->count();
        $totalPengaduanSelesai = Pengaduan::where('status', 'selesai')->count();
        $totalPengaduan = Pengaduan::count();

        return view('warga.landing', compact(
            'profil',
            'jenisSurat',
            'beritaTerbaru',
            'programBantuan',
            'perangkatDesa',
            'totalSuratDisetujui',
            'totalPengaduanSelesai',
            'totalPengaduan'
        ));
    }
}
