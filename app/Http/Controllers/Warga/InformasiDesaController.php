<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\PerangkatDesa;
use App\Models\ProfilDesa;
use App\Models\ProgramBantuan;
use Illuminate\Http\Request;

class InformasiDesaController extends Controller
{
    public function index()
    {
        $profil = ProfilDesa::first();
        $beritaList = Berita::where('is_published', true)->latest('published_at')->paginate(6);
        $programBantuan = ProgramBantuan::latest()->get();
        $perangkatDesa = PerangkatDesa::where('is_active', true)->orderBy('urutan')->get();

        return view('warga.informasi.index', compact('profil', 'beritaList', 'programBantuan', 'perangkatDesa'));
    }

    public function bansos()
    {
        $profil = ProfilDesa::first();
        $programBantuan = ProgramBantuan::latest()->get();

        return view('warga.informasi.bansos', compact('profil', 'programBantuan'));
    }

    public function beritaDetail($slug)
    {
        $berita = Berita::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $berita->increment('views');

        $beritaTerkait = Berita::where('is_published', true)
            ->where('id', '!=', $berita->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('warga.informasi.berita-detail', compact('berita', 'beritaTerkait'));
    }
}
