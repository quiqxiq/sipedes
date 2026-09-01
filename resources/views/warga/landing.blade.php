@extends('layouts.app')

@section('title', 'Pelayanan Surat Online — Desa Rombiyah Barat')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-emerald-900 via-teal-900 to-slate-900 text-white overflow-hidden py-20 lg:py-28">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#10b981_1px,transparent_1px)] [background-size:16px_16px]"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-emerald-300 text-xs font-semibold backdrop-blur-md">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Sistem Pelayanan Digital Desa Rombiyah Barat
                </div>

                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-tight">
                    Pengajuan Surat Desa Cepat, Transparan, & <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-300">Berbasis AI</span>
                </h1>

                <p class="text-slate-300 text-sm sm:text-base leading-relaxed max-w-2xl mx-auto lg:mx-0">
                    Urus surat keterangan domisili, usaha, tidak mampu, hingga pengantar nikah tanpa perlu antre panjang di balai desa. Dilengkapi asisten cerdas AI yang siap menjawab syarat & prosedur 24/7.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-2">
                    <a href="{{ route('warga.pengajuan.wizard') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl font-bold text-sm text-slate-900 bg-gradient-to-r from-emerald-400 to-teal-300 hover:from-emerald-300 hover:to-teal-200 shadow-lg shadow-emerald-500/25 transition-all transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Ajukan Surat Sekarang
                    </a>
                    
                    <a href="#layanan" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl font-semibold text-sm text-white bg-slate-800/80 hover:bg-slate-700/80 border border-slate-700/80 backdrop-blur-md transition-all">
                        Lihat Jenis Surat
                    </a>
                </div>
            </div>

            <!-- Hero Feature Cards -->
            <div class="lg:col-span-5 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="bg-white/10 backdrop-blur-md border border-white/10 rounded-2xl p-5 hover:bg-white/15 transition-all">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center mb-3">
                        ⚡
                    </div>
                    <h3 class="font-bold text-white text-base">Proses Cepat</h3>
                    <p class="text-xs text-slate-300 mt-1">Verifikasi berkas langsung oleh petugas desa secara sistematis.</p>
                </div>

                <div class="bg-white/10 backdrop-blur-md border border-white/10 rounded-2xl p-5 hover:bg-white/15 transition-all">
                    <div class="w-10 h-10 rounded-xl bg-teal-500/20 text-teal-400 flex items-center justify-center mb-3">
                        🤖
                    </div>
                    <h3 class="font-bold text-white text-base">Chatbot AI RAG</h3>
                    <p class="text-xs text-slate-300 mt-1">Tanyakan syarat & prosedur kapan saja ke Asisten AI Desa.</p>
                </div>

                <div class="bg-white/10 backdrop-blur-md border border-white/10 rounded-2xl p-5 hover:bg-white/15 transition-all">
                    <div class="w-10 h-10 rounded-xl bg-sky-500/20 text-sky-400 flex items-center justify-center mb-3">
                        📄
                    </div>
                    <h3 class="font-bold text-white text-base">Cetak PDF Resmi</h3>
                    <p class="text-xs text-slate-300 mt-1">Unduh PDF surat resmi yang telah disetujui langsung dari HP.</p>
                </div>

                <div class="bg-white/10 backdrop-blur-md border border-white/10 rounded-2xl p-5 hover:bg-white/15 transition-all">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center mb-3">
                        🛡️
                    </div>
                    <h3 class="font-bold text-white text-base">Aman & Terverifikasi</h3>
                    <p class="text-xs text-slate-300 mt-1">Data warga terlindungi dengan autentikasi berbasis NIK.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Bar -->
<section class="bg-emerald-800 text-white py-6 border-y border-emerald-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            <div>
                <div class="text-2xl sm:text-3xl font-extrabold">{{ number_format($profil->statistik['jumlah_penduduk'] ?? 4500) }}</div>
                <div class="text-xs text-emerald-200 mt-0.5">Warga Terdaftar</div>
            </div>
            <div>
                <div class="text-2xl sm:text-3xl font-extrabold">{{ $jenisSurat->count() }}</div>
                <div class="text-xs text-emerald-200 mt-0.5">Jenis Layanan Surat</div>
            </div>
            <div>
                <div class="text-2xl sm:text-3xl font-extrabold">{{ number_format($totalSuratDisetujui) }}</div>
                <div class="text-xs text-emerald-200 mt-0.5">Surat Diterbitkan</div>
            </div>
            <div>
                <div class="text-2xl sm:text-3xl font-extrabold">24/7</div>
                <div class="text-xs text-emerald-200 mt-0.5">Layanan AI Chatbot</div>
            </div>
        </div>
    </div>
</section>

<!-- Section Layanan Surat -->
<section id="layanan" class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto space-y-3 mb-12">
            <span class="text-xs font-bold tracking-wider text-emerald-600 uppercase">Layanan Administrasi</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Jenis Surat Yang Dapat Diajukan Online</h2>
            <p class="text-slate-600 text-sm">Pilih jenis surat yang Anda butuhkan, siapkan persyaratan berkas, dan ajukan langsung secara digital.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($jenisSurat as $surat)
                <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm hover:shadow-md transition-all flex flex-col justify-between group">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                                {{ $surat->kode }}
                            </span>
                            <span class="text-xs text-slate-500 font-medium flex items-center gap-1">
                                ⏱️ {{ $surat->estimasi_waktu }}
                            </span>
                        </div>

                        <h3 class="text-lg font-bold text-slate-900 group-hover:text-emerald-600 transition-colors mb-2">
                            {{ $surat->nama }}
                        </h3>

                        <p class="text-slate-600 text-xs leading-relaxed mb-4">
                            {{ $surat->deskripsi }}
                        </p>

                        <div class="space-y-2 mb-6">
                            <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Syarat Berkas:</h4>
                            <ul class="space-y-1">
                                @foreach((array) $surat->syarat as $syaratItem)
                                    <li class="text-xs text-slate-600 flex items-start gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-emerald-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>{{ $syaratItem }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <a href="{{ route('warga.pengajuan.wizard') }}?jenis={{ $surat->id }}" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 transition-all">
                        Buat Permohonan
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Section Alur Pengajuan 3-Langkah -->
<section class="py-16 bg-white border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Alur Mudah Pengajuan Surat</h2>
            <p class="text-slate-600 text-sm mt-2">Hanya butuh 3 langkah sederhana untuk mengajukan surat dari mana saja.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
            <div class="text-center space-y-3">
                <div class="w-14 h-14 rounded-2xl bg-emerald-600 text-white font-bold text-xl flex items-center justify-center mx-auto shadow-lg shadow-emerald-600/20">
                    1
                </div>
                <h3 class="font-bold text-slate-900 text-base">Pilih Jenis Surat</h3>
                <p class="text-xs text-slate-600 leading-relaxed">Pilih layanan surat yang Anda butuhkan (SKU, SKTM, Domisili, dll) dari daftar layanan online.</p>
            </div>

            <div class="text-center space-y-3">
                <div class="w-14 h-14 rounded-2xl bg-teal-600 text-white font-bold text-xl flex items-center justify-center mx-auto shadow-lg shadow-teal-600/20">
                    2
                </div>
                <h3 class="font-bold text-slate-900 text-base">Isi Data & Upload Syarat</h3>
                <p class="text-xs text-slate-600 leading-relaxed">Lengkapi data diri dan unggah foto/scan berkas persyaratan (KTP, KK, Pengantar RT/RW).</p>
            </div>

            <div class="text-center space-y-3">
                <div class="w-14 h-14 rounded-2xl bg-slate-900 text-white font-bold text-xl flex items-center justify-center mx-auto shadow-lg shadow-slate-900/20">
                    3
                </div>
                <h3 class="font-bold text-slate-900 text-base">Verifikasi & Unduh PDF</h3>
                <p class="text-xs text-slate-600 leading-relaxed">Petugas mengecek berkas Anda. Jika disetujui, surat resmi ber-PDF dapat langsung diunduh.</p>
            </div>
        </div>
    </div>
</section>

<!-- Section Profil & Visi Misi Desa -->
<section id="profil" class="py-16 bg-slate-50 border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <div class="lg:col-span-6 space-y-4">
                <span class="text-xs font-bold tracking-wider text-emerald-600 uppercase">Tentang Kami</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">{{ $profil->nama_desa ?? 'Desa Rombiyah Barat' }}</h2>
                <p class="text-slate-600 text-sm leading-relaxed">
                    {{ $profil->sejarah ?? 'Desa Rombiyah Barat terus berkomitmen untuk memberikan pelayanan publik administrasi secara cepat, transparan, dan berbasis teknologi terdepan.' }}
                </p>
                <div class="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-xs space-y-2">
                    <h4 class="font-bold text-slate-900 text-sm">Visi & Misi</h4>
                    <p class="text-xs text-slate-600 whitespace-pre-line leading-relaxed">{{ $profil->visi_misi ?? '' }}</p>
                </div>
            </div>

            <div class="lg:col-span-6 bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                <h3 class="font-bold text-slate-900 text-lg">Informasi Kontak & Jam Kerja Balai Desa</h3>
                
                <div class="space-y-3 text-xs">
                    <div class="flex items-start gap-3 p-3 rounded-xl bg-slate-50">
                        <span class="text-lg">📍</span>
                        <div>
                            <span class="font-bold text-slate-800 block">Alamat Balai Desa</span>
                            <span class="text-slate-600">{{ $profil->kontak['alamat_kantor'] ?? 'Jl. Raya Desa Rombiyah Barat No. 01' }}</span>
                        </div>
                    </div>

                    <div class="flex items-start gap-3 p-3 rounded-xl bg-slate-50">
                        <span class="text-lg">📞</span>
                        <div>
                            <span class="font-bold text-slate-800 block">Kontak & Whatsapp</span>
                            <span class="text-slate-600">{{ $profil->kontak['telepon'] ?? '' }} / WA: {{ $profil->kontak['whatsapp'] ?? '' }}</span>
                        </div>
                    </div>

                    <div class="flex items-start gap-3 p-3 rounded-xl bg-slate-50">
                        <span class="text-lg">✉️</span>
                        <div>
                            <span class="font-bold text-slate-800 block">Email Resmi</span>
                            <span class="text-slate-600">{{ $profil->kontak['email'] ?? 'layanan@rombiyahbarat.desa.id' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
