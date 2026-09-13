<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\AktivitasLog;
use App\Models\Notifikasi;
use App\Models\PermohonanSurat;
use Illuminate\Http\Request;
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

    public function cancel(Request $request, $id)
    {
        $permohonan = PermohonanSurat::where('user_id', Auth::id())->findOrFail($id);

        if (!in_array($permohonan->status, ['diajukan', 'butuh_koreksi'])) {
            return back()->with('error', 'Permohonan surat tidak dapat dibatalkan karena sudah dalam proses atau selesai.');
        }

        $request->validate([
            'alasan_pembatalan' => 'nullable|string|max:500',
        ]);

        $alasan = $request->input('alasan_pembatalan') ?: 'Dibatalkan oleh pemohon.';

        $permohonan->update([
            'status' => 'dibatalkan',
            'catatan_petugas' => ($permohonan->catatan_petugas ? $permohonan->catatan_petugas . "\n" : '') . '[Pembatalan Warga]: ' . $alasan,
        ]);

        Notifikasi::create([
            'user_id' => Auth::id(),
            'permohonan_id' => $permohonan->id,
            'judul' => 'Permohonan Surat Dibatalkan',
            'pesan' => "Permohonan surat {$permohonan->jenisSurat?->nama} (No: {$permohonan->nomor_permohonan}) berhasil dibatalkan.",
        ]);

        AktivitasLog::catat(Auth::id(), 'surat', 'pembatalan', "Membatalkan permohonan surat #{$permohonan->nomor_permohonan}");

        return redirect()->route('warga.riwayat.show', $permohonan->id)->with('success', 'Permohonan surat berhasil dibatalkan.');
    }
}

