<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\JenisSurat;
use App\Models\PermohonanSurat;
use App\Models\ProfilDesa;

class LandingController extends Controller
{
    public function index()
    {
        $profil = ProfilDesa::first();
        $jenisSurat = JenisSurat::where('is_active', true)->get();
        $totalSuratDisetujui = PermohonanSurat::where('status', 'disetujui')->count();
        $totalPermohonan = PermohonanSurat::count();

        return view('warga.landing', compact('profil', 'jenisSurat', 'totalSuratDisetujui', 'totalPermohonan'));
    }
}
