<?php

namespace App\Http\Controllers;

use App\Models\PermohonanSurat;
use App\Models\ProfilDesa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class SuratPdfController extends Controller
{
    public function generatePdf($id)
    {
        $permohonan = PermohonanSurat::with(['jenisSurat', 'user', 'petugas'])->findOrFail($id);

        // Security check: ensure user owns the letter or is admin/petugas
        if (Auth::user()->isWarga() && $permohonan->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke surat ini.');
        }

        if ($permohonan->status !== 'disetujui') {
            return back()->with('error', 'Surat belum disetujui oleh petugas desa.');
        }

        $profil = ProfilDesa::first();

        // Siapkan Logo Resmi Desa Rombiya Barat dalam format Base64 Data URI untuk DomPDF
        $logoPath = public_path('images/logo.png');
        $logoBase64 = file_exists($logoPath)
            ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath))
            : null;

        // Tanggal terbit surat dalam format bahasa Indonesia
        $tanggalObj = $permohonan->tanggal_selesai ?? $permohonan->updated_at ?? now();
        $tanggalSurat = $tanggalObj->translatedFormat('d F Y');

        // Nama Kepala Desa resmi
        $kadesName = !empty($profil?->kepala_desa) ? strtoupper($profil->kepala_desa) : 'HJ. FEBRI';

        $pdf = Pdf::loadView('pdf.surat-template', [
            'permohonan' => $permohonan,
            'profil' => $profil,
            'logoBase64' => $logoBase64,
            'tanggalSurat' => $tanggalSurat,
            'kadesName' => $kadesName,
        ])->setPaper('a4', 'portrait');

        $fileName = 'Surat_' . $permohonan->jenisSurat->kode . '_' . str_replace('/', '_', $permohonan->nomor_permohonan) . '.pdf';

        return $pdf->stream($fileName);
    }
}
