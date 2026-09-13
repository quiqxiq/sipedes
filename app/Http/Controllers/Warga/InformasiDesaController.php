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

    public function bansos(Request $request)
    {
        $profil = ProfilDesa::first();
        $programBantuan = ProgramBantuan::latest()->get();

        $queryNik = trim($request->input('nik', ''));
        $queryNama = trim($request->input('nama', ''));
        $queryDusun = $request->input('dusun', '');
        $queryKategori = $request->input('kategori', '');

        $hasSearched = $request->filled('nik') || $request->filled('nama') || $request->filled('dusun') || $request->filled('kategori');
        $hasilPencarian = collect();

        if ($hasSearched) {
            $penerimaQuery = \App\Models\PenerimaBantuan::with('programBantuan');

            if (!empty($queryNik)) {
                $penerimaQuery->where('nik', $queryNik);
            }

            if (!empty($queryNama)) {
                $penerimaQuery->where('nama_penerima', 'like', "%{$queryNama}%");
            }

            if (!empty($queryDusun)) {
                $penerimaQuery->where('dusun', $queryDusun);
            }

            if (!empty($queryKategori)) {
                $penerimaQuery->whereHas('programBantuan', function ($q) use ($queryKategori) {
                    $q->where('kategori', $queryKategori);
                })->orWhere('jenis_bansos', 'like', "%{$queryKategori}%");
            }

            $hasilPencarian = $penerimaQuery->latest()->get();
        }

        $totalKpm = \App\Models\PenerimaBantuan::count();
        $totalProgram = $programBantuan->count();

        return view('warga.informasi.bansos', compact(
            'profil',
            'programBantuan',
            'hasSearched',
            'hasilPencarian',
            'queryNik',
            'queryNama',
            'queryDusun',
            'queryKategori',
            'totalKpm',
            'totalProgram'
        ));
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
