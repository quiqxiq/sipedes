@extends('layouts.app')

@section('title', 'Dashboard Warga — SIPEDES Desa Rombiya Barat')

@section('content')
<div class="py-10 bg-slate-50 min-h-[85vh]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Welcome Banner -->
        <div class="bg-gradient-to-r from-emerald-800 to-teal-700 rounded-3xl p-6 sm:p-8 text-white shadow-lg relative overflow-hidden">
            <div class="relative z-10 space-y-2">
                <div class="flex items-center gap-2 mb-2">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Desa Rombiya Barat" class="w-8 h-8 object-contain rounded-lg bg-white/10 p-0.5">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-white/20 backdrop-blur-md">
                        Portal Pelayanan Warga &bull; Desa Rombiya Barat
                    </span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold">Selamat Datang, {{ $user->name }}!</h1>
                <p class="text-emerald-100 text-xs sm:text-sm max-w-xl">
                    NIK: {{ substr($user->nik, 0, 4) . '****' . substr($user->nik, -4) }} | Dusun: {{ $user->dusun ?? 'Desa Rombiya Barat' }} | Telepon: {{ $user->telepon }}
                </p>
            </div>
            
            <div class="mt-6 flex flex-wrap gap-3 relative z-10">
                <a href="{{ route('warga.pengajuan.wizard') }}" class="px-5 py-2.5 rounded-xl bg-white text-emerald-800 font-bold text-xs hover:bg-emerald-50 shadow-sm transition-all flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-emerald-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Buat Permohonan Surat
                </a>
                <a href="{{ route('warga.pengaduan.create') }}" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs shadow-sm transition-all flex items-center gap-1.5 border border-emerald-400/40">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                    Lapor Pengaduan Warga
                </a>
                <a href="{{ route('warga.pengaduan.index') }}" class="px-5 py-2.5 rounded-xl bg-emerald-900/60 hover:bg-emerald-900/80 text-white font-medium text-xs border border-emerald-500/30 backdrop-blur-md transition-all flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    Riwayat Laporan Saya
                </a>
                <a href="{{ route('warga.informasi.bansos', ['nik' => $user->nik]) }}" class="px-5 py-2.5 rounded-xl bg-teal-600/80 hover:bg-teal-500 text-white font-bold text-xs border border-teal-400/40 backdrop-blur-md transition-all flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-teal-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Cek Status Bansos
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

        <!-- Widget Status Bansos Warga -->
        <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200 shadow-xs space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h2 class="text-base font-extrabold text-slate-900">Status Bantuan Sosial (Bansos) Akun Anda</h2>
                        <p class="text-xs text-slate-500">Berdasarkan NIK: {{ substr($user->nik, 0, 4) . '****' . substr($user->nik, -4) }}</p>
                    </div>
                </div>
                <a href="{{ route('warga.informasi.bansos') }}" class="text-xs font-bold text-emerald-600 hover:underline inline-flex items-center gap-1">
                    Cek Seluruh Bansos Desa &rarr;
                </a>
            </div>

            @if($bansosUser->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($bansosUser as $bansosItem)
                        <div class="p-4 rounded-2xl bg-gradient-to-br from-emerald-50 to-teal-50 border border-emerald-200 space-y-2">
                            <div class="flex items-center justify-between gap-2">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                    {{ $bansosItem->jenis_bansos }}
                                </span>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $bansosItem->status_penyaluran == 'siap_diambil' ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800' }}">
                                    {{ $bansosItem->status_label }}
                                </span>
                            </div>
                            <div>
                                <span class="text-[11px] text-slate-500 block">Bantuan yang Diterima:</span>
                                <strong class="text-sm text-emerald-950 font-bold block">{{ $bansosItem->rincian_yang_diterima }}</strong>
                            </div>
                            <div class="text-xs text-slate-600 space-y-0.5 pt-1 border-t border-emerald-200/60">
                                <p><strong>Periode:</strong> {{ $bansosItem->periode }}</p>
                                <p><strong>Lokasi:</strong> {{ $bansosItem->lokasi_pengambilan }}</p>
                                @if($bansosItem->tanggal_penyaluran)
                                    <p><strong>Jadwal:</strong> {{ $bansosItem->tanggal_penyaluran->format('d M Y') }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-xs text-slate-600 flex flex-col sm:flex-row items-center justify-between gap-3">
                    <p>NIK Anda saat ini belum tercatat dalam daftar penyaluran bantuan aktif. Bansos ditetapkan berdasarkan data DTKS Kemensos dan hasil Musyawarah Desa.</p>
                    <a href="{{ route('warga.informasi.bansos') }}" class="shrink-0 px-3.5 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs transition-all">
                        Cek Database KPM
                    </a>
                </div>
            @endif
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
                    <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto">
                        <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
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
                                        @elseif($item->status == 'dibatalkan')
                                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-slate-100 text-slate-700">Dibatalkan</span>
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
