@extends('layouts.app')

@section('title', 'Detail Permohonan — ' . $permohonan->nomor_permohonan)

@section('content')
<div class="py-10 bg-slate-50 min-h-[85vh]">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        
        <!-- Breadcrumb / Back -->
        <div>
            <a href="{{ route('warga.riwayat.index') }}" class="text-xs font-semibold text-slate-500 hover:text-emerald-600 inline-flex items-center gap-1 transition-colors">
                &larr; Kembali ke Riwayat Surat
            </a>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-6">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between border-b border-slate-100 pb-6 gap-4">
                <div>
                    <span class="text-xs font-mono font-bold text-emerald-600 block">{{ $permohonan->nomor_permohonan }}</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 mt-1">{{ $permohonan->jenisSurat->nama ?? '-' }}</h1>
                    <p class="text-xs text-slate-500 mt-0.5">Tanggal Pengajuan: {{ $permohonan->created_at->format('d M Y, H:i') }} WIB</p>
                </div>

                <div>
                    @if($permohonan->status == 'diajukan')
                        <span class="px-3 py-1.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800">Menunggu Verifikasi</span>
                    @elseif($permohonan->status == 'diproses')
                        <span class="px-3 py-1.5 rounded-full text-xs font-bold bg-sky-100 text-sky-800">Sedang Diproses</span>
                    @elseif($permohonan->status == 'disetujui')
                        <span class="px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">Disetujui</span>
                    @elseif($permohonan->status == 'butuh_koreksi')
                        <span class="px-3 py-1.5 rounded-full text-xs font-bold bg-orange-100 text-orange-800">Butuh Koreksi</span>
                    @elseif($permohonan->status == 'dibatalkan')
                        <span class="px-3 py-1.5 rounded-full text-xs font-bold bg-slate-100 text-slate-700">Dibatalkan</span>
                    @else
                        <span class="px-3 py-1.5 rounded-full text-xs font-bold bg-rose-100 text-rose-800">Ditolak</span>
                    @endif
                </div>
            </div>

            <!-- Catatan Petugas jika ada -->
            @if($permohonan->catatan_petugas)
                <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 text-xs space-y-1">
                    <span class="font-bold block">💬 Catatan Petugas / Status:</span>
                    <p class="text-amber-800 leading-relaxed whitespace-pre-line">{{ $permohonan->catatan_petugas }}</p>
                </div>
            @endif

            <!-- Data Pemohon & Lampiran -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-3">
                    <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Data Pemohon</h3>
                    <div class="bg-slate-50 p-4 rounded-2xl space-y-2 text-xs">
                        <div class="flex justify-between"><span class="text-slate-500">Nama:</span> <span class="font-bold text-slate-800">{{ Auth::user()->name }}</span></div>
                        <div class="flex justify-between"><span class="text-slate-500">NIK:</span> <span class="font-mono text-slate-800">{{ Auth::user()->nik }}</span></div>
                        <div class="flex justify-between"><span class="text-slate-500">No. Telepon:</span> <span class="text-slate-800">{{ Auth::user()->telepon }}</span></div>
                        <div class="flex justify-between"><span class="text-slate-500">Alamat:</span> <span class="text-slate-800 text-right max-w-[200px]">{{ Auth::user()->alamat }}</span></div>
                    </div>
                </div>

                <div class="space-y-3">
                    <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Dokumen Lampiran Persyaratan</h3>
                    <div class="bg-slate-50 p-4 rounded-2xl space-y-2 text-xs">
                        @forelse($permohonan->dokumenPersyaratan as $doc)
                            <div class="flex items-center justify-between p-2.5 rounded-xl bg-white border border-slate-200">
                                <div class="flex items-center gap-2 truncate max-w-[240px]">
                                    @if($doc->tipe_dokumen)
                                        <span class="px-2 py-0.5 rounded-md bg-emerald-100 text-emerald-800 text-[10px] font-bold shrink-0">
                                            {{ $doc->tipe_dokumen }}
                                        </span>
                                    @endif
                                    <span class="font-medium text-slate-800 truncate">{{ $doc->nama_file }}</span>
                                </div>
                                <a href="{{ asset('storage/' . $doc->path) }}" target="_blank" class="text-emerald-600 font-bold hover:underline shrink-0 ml-2">Pratinjau &rarr;</a>
                            </div>
                        @empty
                            <p class="text-slate-500 italic">Tidak ada dokumen terlampir.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Aksi Pembatalan jika masih diajukan / butuh_koreksi -->
            @if(in_array($permohonan->status, ['diajukan', 'butuh_koreksi']))
                <div x-data="{ openCancelModal: false }" class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div>
                        <span class="text-xs font-bold text-slate-700 block">Batalkan Pengajuan Surat?</span>
                        <span class="text-[11px] text-slate-500">Anda masih dapat membatalkan permohonan ini selama belum diproses atau disetujui petugas desa.</span>
                    </div>
                    <button type="button" @click="openCancelModal = true" class="px-4 py-2.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 font-bold text-xs transition-all flex items-center gap-1.5 shrink-0">
                        <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Batalkan Pengajuan
                    </button>

                    <!-- Modal Konfirmasi Pembatalan -->
                    <div x-show="openCancelModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
                        <div @click.away="openCancelModal = false" class="bg-white rounded-3xl max-w-md w-full p-6 space-y-4 shadow-xl border border-slate-100">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center font-bold text-lg shrink-0">
                                    ⚠️
                                </div>
                                <div>
                                    <h3 class="text-base font-bold text-slate-900">Batalkan Permohonan Surat?</h3>
                                    <p class="text-xs text-slate-500">Tindakan ini tidak dapat diurungkan.</p>
                                </div>
                            </div>

                            <form action="{{ route('warga.riwayat.cancel', $permohonan->id) }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="alasan_pembatalan" class="block text-xs font-bold text-slate-700 mb-1">Alasan Pembatalan (Opsional)</label>
                                    <textarea name="alasan_pembatalan" id="alasan_pembatalan" rows="3" class="w-full text-xs rounded-xl border border-slate-300 focus:border-rose-500 focus:ring-rose-500 p-3" placeholder="Contoh: Terjadi kesalahan data atau tidak lagi membutuhkan surat ini..."></textarea>
                                </div>

                                <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100">
                                    <button type="button" @click="openCancelModal = false" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-colors">
                                        Kembali
                                    </button>
                                    <button type="submit" class="px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-500 text-white font-bold text-xs shadow-sm transition-colors">
                                        Ya, Batalkan Pengajuan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Tombol Unduh jika Disetujui -->
            @if($permohonan->status == 'disetujui')
                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold text-emerald-700 block">Surat Resmi Berhasil Diterbitkan</span>
                        <span class="text-[11px] text-slate-500">Anda dapat mengunduh dokumen PDF resmi kapan saja.</span>
                    </div>
                    <a href="{{ route('warga.surat.pdf', $permohonan->id) }}" target="_blank" class="px-5 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs shadow-md transition-all">
                        Unduh PDF Surat Official
                    </a>
                </div>
            @endif


        </div>

    </div>
</div>
@endsection
