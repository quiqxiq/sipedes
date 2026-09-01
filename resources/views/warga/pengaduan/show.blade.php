@extends('layouts.app')

@section('title', 'Detail Laporan ' . $pengaduan->kode_tiket . ' — SIPEDES')

@section('content')
<div class="min-h-screen bg-slate-50 py-10">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-6 flex items-center justify-between">
            <a href="{{ route('warga.pengaduan.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-600 hover:text-emerald-700">
                &larr; Kembali ke Daftar Laporan
            </a>
            <span class="font-mono font-bold text-xs bg-slate-200 text-slate-800 px-3 py-1 rounded-lg">
                Tiket: {{ $pengaduan->kode_tiket }}
            </span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Left: Main Detail -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-5">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                        <div>
                            <span class="text-[11px] font-bold text-emerald-600 uppercase tracking-wider">{{ $pengaduan->kategori_label }}</span>
                            <h1 class="text-lg sm:text-xl font-extrabold text-slate-900 mt-0.5">{{ $pengaduan->judul }}</h1>
                        </div>
                    </div>

                    <div class="text-xs space-y-4">
                        <div>
                            <strong class="text-slate-700 block mb-1">Lokasi Kejadian:</strong>
                            <p class="text-slate-600 bg-slate-50 p-3 rounded-xl border border-slate-100">
                                <strong>{{ $pengaduan->dusun }}</strong>
                                @if($pengaduan->lokasi_detail)
                                    &bull; {{ $pengaduan->lokasi_detail }}
                                @endif
                            </p>
                        </div>

                        <div>
                            <strong class="text-slate-700 block mb-1">Isi Laporan Warga:</strong>
                            <p class="text-slate-700 whitespace-pre-line leading-relaxed bg-slate-50 p-4 rounded-xl border border-slate-100">{{ $pengaduan->deskripsi }}</p>
                        </div>

                        @if($pengaduan->foto_lampiran)
                            <div>
                                <strong class="text-slate-700 block mb-1.5">Foto Bukti Lapangan:</strong>
                                <div class="rounded-2xl overflow-hidden border border-slate-200 max-w-md">
                                    <img src="{{ asset('storage/' . $pengaduan->foto_lampiran) }}" alt="Bukti Laporan" class="w-full h-auto object-cover">
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Respon Petugas -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-3">
                    <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h5m-5 0v-4m0 4h5m-5 0v-4m0 0h-5m5 0V7"></path>
                        </svg>
                        Tindak Lanjut & Tanggapan Balai Desa
                    </h3>

                    @if($pengaduan->tanggapan_petugas)
                        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-100 text-xs text-emerald-900 space-y-2">
                            <p class="whitespace-pre-line leading-relaxed font-medium">{{ $pengaduan->tanggapan_petugas }}</p>
                            <div class="text-[11px] text-emerald-700 pt-2 border-t border-emerald-200/60 flex items-center justify-between">
                                <span>Petugas: {{ $pengaduan->petugas->name ?? 'Pamong Desa Rombiyah Barat' }}</span>
                                <span>{{ $pengaduan->ditanggapi_at ? $pengaduan->ditanggapi_at->format('d M Y, H:i') : '' }}</span>
                            </div>
                        </div>
                    @else
                        <div class="p-4 rounded-2xl bg-amber-50 border border-amber-100 text-xs text-amber-800">
                            Laporan Anda telah masuk ke sistem dan sedang menunggu peninjauan oleh perangkat desa / Kasun terkait.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right: Status Tracking Timeline -->
            <div class="space-y-6">
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-4">
                    <h3 class="font-bold text-slate-900 text-xs uppercase tracking-wider">Status Laporan</h3>

                    <div class="text-center py-3">
                        @if($pengaduan->status === 'menunggu')
                            <div class="w-12 h-12 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center mx-auto mb-2">
                                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <span class="font-bold text-sm text-amber-800 block">Menunggu Verifikasi</span>
                            <span class="text-[11px] text-slate-500">Laporan baru terkirim</span>
                        @elseif($pengaduan->status === 'diproses')
                            <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mx-auto mb-2">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <span class="font-bold text-sm text-blue-800 block">Sedang Ditindaklanjuti</span>
                            <span class="text-[11px] text-slate-500">Dalam penanganan pamong</span>
                        @elseif($pengaduan->status === 'selesai')
                            <div class="w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto mb-2">
                                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span class="font-bold text-sm text-emerald-800 block">Selesai Ditangani</span>
                            <span class="text-[11px] text-slate-500">Telah diselesaikan oleh desa</span>
                        @else
                            <div class="w-12 h-12 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mx-auto mb-2">
                                <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </div>
                            <span class="font-bold text-sm text-rose-800 block">Laporan Ditolak</span>
                            <span class="text-[11px] text-slate-500">Lihat catatan petugas</span>
                        @endif
                    </div>

                    <div class="text-xs text-slate-500 space-y-2 pt-3 border-t border-slate-100">
                        <div class="flex justify-between">
                            <span>Waktu Lapor:</span>
                            <strong class="text-slate-700">{{ $pengaduan->created_at->format('d/m/Y H:i') }}</strong>
                        </div>
                        <div class="flex justify-between">
                            <span>Pelapor:</span>
                            <strong class="text-slate-700">{{ $pengaduan->user->name }}</strong>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
