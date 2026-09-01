@extends('layouts.app')

@section('title', 'Dashboard Warga — SIPEDES')

@section('content')
<div class="py-10 bg-slate-50 min-h-[85vh]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Welcome Banner -->
        <div class="bg-gradient-to-r from-emerald-800 to-teal-700 rounded-3xl p-6 sm:p-8 text-white shadow-lg relative overflow-hidden">
            <div class="relative z-10 space-y-2">
                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-white/20 backdrop-blur-md">
                    Portal Pelayanan Warga
                </span>
                <h1 class="text-2xl sm:text-3xl font-extrabold">Selamat Datang, {{ $user->name }}!</h1>
                <p class="text-emerald-100 text-xs sm:text-sm max-w-xl">
                    NIK: {{ substr($user->nik, 0, 4) . '****' . substr($user->nik, -4) }} | Telepon: {{ $user->telepon }}
                </p>
            </div>
            
            <div class="mt-6 flex flex-wrap gap-3 relative z-10">
                <a href="{{ route('warga.pengajuan.wizard') }}" class="px-5 py-2.5 rounded-xl bg-white text-emerald-800 font-bold text-xs hover:bg-emerald-50 shadow-sm transition-all flex items-center gap-1.5">
                    <span>✍️</span> Buat Permohonan Surat Baru
                </a>
                <a href="{{ route('warga.riwayat.index') }}" class="px-5 py-2.5 rounded-xl bg-emerald-900/60 hover:bg-emerald-900/80 text-white font-medium text-xs border border-emerald-500/30 backdrop-blur-md transition-all flex items-center gap-1.5">
                    <span>📋</span> Lihat Riwayat Saya
                </a>
            </div>
        </div>

        <!-- Metric Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-2">
                <span class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Total Permohonan</span>
                <div class="text-3xl font-extrabold text-slate-900">{{ number_format($totalPermohonan) }}</div>
                <p class="text-xs text-slate-500">Seluruh permohonan yang pernah diajukan</p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-2">
                <span class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Sedang Diproses</span>
                <div class="text-3xl font-extrabold text-amber-600">{{ number_format($totalProses) }}</div>
                <p class="text-xs text-slate-500">Menunggu verifikasi petugas desa</p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-2">
                <span class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Surat Disetujui</span>
                <div class="text-3xl font-extrabold text-emerald-600">{{ number_format($totalDisetujui) }}</div>
                <p class="text-xs text-slate-500">Dapat langsung diunduh format PDF</p>
            </div>
        </div>

        <!-- Permohonan Terakhir Table -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-bold text-slate-900">Permohonan Surat Terakhir</h2>
                    <p class="text-xs text-slate-500">Status 5 pengajuan surat terbaru Anda</p>
                </div>
                <a href="{{ route('warga.riwayat.index') }}" class="text-xs font-bold text-emerald-600 hover:underline">
                    Lihat Semua &rarr;
                </a>
            </div>

            @if($permohonanTerakhir->isEmpty())
                <div class="p-12 text-center space-y-3">
                    <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto text-xl">
                        📭
                    </div>
                    <p class="text-xs text-slate-500">Anda belum pernah mengajukan permohonan surat.</p>
                    <a href="{{ route('warga.pengajuan.wizard') }}" class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold text-white bg-emerald-600 rounded-xl hover:bg-emerald-500 transition-all">
                        Ajukan Surat Sekarang
                    </a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-600 font-semibold border-b border-slate-200">
                            <tr>
                                <th class="p-4">No. Permohonan</th>
                                <th class="p-4">Jenis Surat</th>
                                <th class="p-4">Tanggal Pengajuan</th>
                                <th class="p-4">Status</th>
                                <th class="p-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($permohonanTerakhir as $item)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="p-4 font-mono font-bold text-slate-800">{{ $item->nomor_permohonan }}</td>
                                    <td class="p-4 font-semibold text-slate-900">{{ $item->jenisSurat->nama ?? '-' }}</td>
                                    <td class="p-4 text-slate-500">{{ $item->created_at->format('d M Y H:i') }}</td>
                                    <td class="p-4">
                                        @if($item->status == 'diajukan')
                                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-100 text-amber-800">Diajukan</span>
                                        @elseif($item->status == 'diproses')
                                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-sky-100 text-sky-800">Diproses</span>
                                        @elseif($item->status == 'disetujui')
                                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">Disetujui</span>
                                        @elseif($item->status == 'butuh_koreksi')
                                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-orange-100 text-orange-800">Butuh Koreksi</span>
                                        @else
                                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-rose-100 text-rose-800">Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-right">
                                        <a href="{{ route('warga.riwayat.show', $item->id) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
