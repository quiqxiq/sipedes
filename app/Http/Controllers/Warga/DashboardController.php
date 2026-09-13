<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\PermohonanSurat;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $permohonanQuery = PermohonanSurat::where('user_id', $user->id);
        $totalPermohonan = (clone $permohonanQuery)->count();
        $totalProses = (clone $permohonanQuery)->whereIn('status', ['diajukan', 'diproses'])->count();
        $totalDisetujui = (clone $permohonanQuery)->where('status', 'disetujui')->count();

        $permohonanTerakhir = (clone $permohonanQuery)
            ->with('jenisSurat')
            ->latest()
            ->take(5)
            ->get();

        $bansosUser = \App\Models\PenerimaBantuan::with('programBantuan')
            ->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->orWhere('nik', $user->nik);
            })
            ->latest()
            ->get();

        return view('warga.dashboard', compact('user', 'permohonanTerakhir', 'totalPermohonan', 'totalProses', 'totalDisetujui', 'bansosUser'));
    }
}
