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

        $pdf = Pdf::loadView('pdf.surat-template', [
            'permohonan' => $permohonan,
            'profil' => $profil,
        ])->setPaper('a4', 'portrait');

        $fileName = 'Surat_' . $permohonan->jenisSurat->kode . '_' . str_replace('/', '_', $permohonan->nomor_permohonan) . '.pdf';

        return $pdf->stream($fileName);
    }
}
