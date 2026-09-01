@extends('layouts.app')

@section('title', 'Riwayat Pengaduan Saya — Desa Rombiyah Barat')

@section('content')
<div class="min-h-screen bg-slate-50 py-10">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900">Riwayat Pengaduan & Aspirasi</h1>
                <p class="text-xs text-slate-600 mt-1">Pantau tindak lanjut laporan keluhan dan aspirasi Anda oleh Pemerintah Desa Rombiyah Barat.</p>
            </div>
            <a href="{{ route('warga.pengaduan.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs shadow-md shadow-emerald-600/20 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Buat Laporan Baru
            </a>
        </div>

        @if($pengaduan->count() > 0)
            <div class="space-y-4">
                @foreach($pengaduan as $item)
                    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs hover:border-emerald-300 transition-all">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-4 border-b border-slate-100">
                            <div class="flex items-center gap-2.5">
                                <span class="font-mono font-bold text-xs text-emerald-800 bg-emerald-50 px-2.5 py-1 rounded-lg border border-emerald-200">
                                    {{ $item->kode_tiket }}
                                </span>
                                <span class="text-xs text-slate-600 font-semibold">{{ $item->dusun }}</span>
                                <span class="text-xs text-slate-400">&bull;</span>
                                <span class="text-xs text-slate-500">{{ $item->kategori_label }}</span>
                            </div>
                            <div>
                                @if($item->status === 'menunggu')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800">
                                        Menunggu Verifikasi
                                    </span>
                                @elseif($item->status === 'diproses')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                                        Sedang Ditindaklanjuti
                                    </span>
                                @elseif($item->status === 'selesai')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                                        Selesai Ditangani
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-800">
                                        Ditolak
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="py-4">
                            <h3 class="font-bold text-slate-900 text-sm mb-1">{{ $item->judul }}</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">{{ Str::limit($item->deskripsi, 180) }}</p>
                            
                            @if($item->tanggapan_petugas)
                                <div class="mt-3 p-3.5 rounded-xl bg-emerald-50/60 border border-emerald-100 text-xs">
                                    <strong class="text-emerald-900 block mb-0.5">Tanggapan Balai Desa:</strong>
                                    <p class="text-emerald-800">{{ $item->tanggapan_petugas }}</p>
                                </div>
                            @endif
                        </div>

                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                            <span>Dilaporkan pada {{ $item->created_at->format('d M Y, H:i') }} WIB</span>
                            <a href="{{ route('warga.pengaduan.show', $item->id) }}" class="font-bold text-emerald-600 hover:text-emerald-700">
                                Lihat Detail & Timeline &rarr;
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $pengaduan->links() }}
            </div>
        @else
            <div class="text-center py-16 bg-white rounded-3xl border border-slate-200 p-8 space-y-3">
                <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto">
                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-slate-800 text-base">Belum Ada Riwayat Laporan</h3>
                <p class="text-xs text-slate-500 max-w-sm mx-auto">
                    Anda belum pernah mengirimkan aspirasi atau pengaduan. Klik tombol di bawah untuk menyampaikan laporan ke balai desa.
                </p>
                <div class="pt-2">
                    <a href="{{ route('warga.pengaduan.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-600 text-white font-bold text-xs hover:bg-emerald-500 shadow-sm transition-all">
                        Buat Laporan Baru Sekarang
                    </a>
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
