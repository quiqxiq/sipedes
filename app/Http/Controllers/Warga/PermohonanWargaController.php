<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\PermohonanSurat;
use Illuminate\Support\Facades\Auth;

class PermohonanWargaController extends Controller
{
    public function index()
    {
        $permohonanList = PermohonanSurat::with(['jenisSurat', 'dokumenPersyaratan'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('warga.riwayat.index', compact('permohonanList'));
    }

    public function show($id)
    {
        $permohonan = PermohonanSurat::with(['jenisSurat', 'dokumenPersyaratan', 'petugas'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('warga.riwayat.show', compact('permohonan'));
    }
}
