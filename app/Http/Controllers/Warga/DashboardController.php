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

        $permohonanTerakhir = PermohonanSurat::with('jenisSurat')
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $totalPermohonan = PermohonanSurat::where('user_id', $user->id)->count();
        $totalProses = PermohonanSurat::where('user_id', $user->id)->whereIn('status', ['diajukan', 'diproses'])->count();
        $totalDisetujui = PermohonanSurat::where('user_id', $user->id)->where('status', 'disetujui')->count();

        return view('warga.dashboard', compact('user', 'permohonanTerakhir', 'totalPermohonan', 'totalProses', 'totalDisetujui'));
    }
}
