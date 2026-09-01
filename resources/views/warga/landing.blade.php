@extends('layouts.app')

@section('title', 'SIPEDES — Pelayanan Terpadu Desa Rombiyah Barat, Ganding, Sumenep')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-emerald-950 via-teal-900 to-slate-900 text-white overflow-hidden py-16 lg:py-24">
    <div class="absolute inset-0 opacity-15 bg-[radial-gradient(#10b981_1px,transparent_1px)] [background-size:20px_20px]"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-emerald-300 text-xs font-semibold backdrop-blur-md">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Pemerintah Desa Rombiyah Barat &bull; Kec. Ganding &bull; Kab. Sumenep
                </div>

                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-tight">
                    Portal Pelayanan Terpadu & Informasi Digital <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-teal-300 to-cyan-200">Desa Rombiyah Barat</span>
                </h1>

                <p class="text-slate-300 text-sm sm:text-base leading-relaxed max-w-2xl mx-auto lg:mx-0">
                    Layanan terintegrasi bagi seluruh warga di <strong>5 Dusun (Kebunan, Buwa, Tanodung, Rombiya, Kalampok)</strong>. Urus surat desa, sampaikan aspirasi/pengaduan, pantau bantuan sosial, dan dapatkan jawaban instan dari Asisten AI Desa 24/7.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-3.5 pt-2">
                    <a href="{{ route('warga.pengajuan.wizard') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl font-bold text-sm text-slate-900 bg-gradient-to-r from-emerald-400 to-teal-300 hover:from-emerald-300 hover:to-teal-200 shadow-lg shadow-emerald-500/25 transition-all transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Ajukan Surat Online
                    </a>

                    <a href="{{ route('warga.pengaduan.create') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl font-bold text-sm text-white bg-emerald-700/80 hover:bg-emerald-600/80 border border-emerald-500/50 backdrop-blur-md shadow-md transition-all">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        Lapor Pengaduan / Masalah
                    </a>
                </div>
            </div>

            <!-- Quick Service Highlights -->
            <div class="lg:col-span-5 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <a href="{{ route('warga.pengajuan.wizard') }}" class="bg-white/10 backdrop-blur-md border border-white/15 rounded-2xl p-5 hover:bg-white/20 transition-all block group">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500/25 text-emerald-400 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-white text-sm">Persuratan Cepat</h3>
                    <p class="text-xs text-slate-300 mt-1">SKU Tani/Usaha, SKTM, Domisili, Nikah, Kematian, Kepemilikan Ternak.</p>
                </a>

                <a href="{{ route('warga.pengaduan.create') }}" class="bg-white/10 backdrop-blur-md border border-white/15 rounded-2xl p-5 hover:bg-white/20 transition-all block group">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/25 text-amber-400 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-white text-sm">Lapor Warga</h3>
                    <p class="text-xs text-slate-300 mt-1">Aspirasi pupuk sawah, jalan dusun, bansos, dan lingkungan.</p>
                </a>

                <a href="{{ route('warga.informasi.bansos') }}" class="bg-white/10 backdrop-blur-md border border-white/15 rounded-2xl p-5 hover:bg-white/20 transition-all block group">
                    <div class="w-10 h-10 rounded-xl bg-teal-500/25 text-teal-400 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-white text-sm">Transparansi Bansos</h3>
                    <p class="text-xs text-slate-300 mt-1">Katalog BLT-DD, Bansos Beras CBP, dan Program Gizi Stunting.</p>
                </a>

                <div class="bg-white/10 backdrop-blur-md border border-white/15 rounded-2xl p-5 hover:bg-white/20 transition-all block">
                    <div class="w-10 h-10 rounded-xl bg-cyan-500/25 text-cyan-400 flex items-center justify-center mb-3">
                        <svg class="w-5 h-5 text-cyan-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-white text-sm">Asisten AI Desa 24/7</h3>
                    <p class="text-xs text-slate-300 mt-1">Tanya syarat layanan & jadwal balai desa kapan saja via chatbot.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Bar Wilayah Desa -->
<section class="bg-emerald-900 text-white py-6 border-y border-emerald-800 shadow-inner">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            <div>
                <div class="text-2xl sm:text-3xl font-extrabold text-emerald-300">{{ number_format($profil->statistik['jumlah_penduduk'] ?? 4820) }}</div>
                <div class="text-xs text-emerald-100/80 mt-0.5">Penduduk Desa Rombiyah Barat</div>
            </div>
            <div>
                <div class="text-2xl sm:text-3xl font-extrabold text-emerald-300">5 Dusun</div>
                <div class="text-xs text-emerald-100/80 mt-0.5">Kebunan, Buwa, Tanodung, Rombiya, Kalampok</div>
            </div>
            <div>
                <div class="text-2xl sm:text-3xl font-extrabold text-emerald-300">{{ number_format($totalSuratDisetujui) }}</div>
                <div class="text-xs text-emerald-100/80 mt-0.5">Surat Diterbitkan</div>
            </div>
            <div>
                <div class="text-2xl sm:text-3xl font-extrabold text-emerald-300">{{ number_format($totalPengaduanSelesai) }}</div>
                <div class="text-xs text-emerald-100/80 mt-0.5">Laporan Warga Ditangani</div>
            </div>
        </div>
    </div>
</section>

<!-- Section 4 Pilar Layanan Terpadu -->
<section class="py-14 bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto space-y-2 mb-10">
            <span class="text-xs font-bold tracking-wider text-emerald-600 uppercase">Pelayanan Publik Terpadu</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Kemudahan Akses Pelayanan Masyarakat</h2>
            <p class="text-slate-600 text-xs sm:text-sm">Pemerintah Desa Rombiyah Barat berkomitmen menghadirkan tata kelola pemerintahan yang terbuka, cepat, dan responsif.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Pilar 1: Surat Online -->
            <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/80 hover:border-emerald-300 hover:shadow-md transition-all flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-xl mb-4">
                        <svg class="w-6 h-6 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Pelayanan Administrasi Surat</h3>
                    <p class="text-xs text-slate-600 leading-relaxed mb-4">
                        Ajukan surat keterangan usaha (SKU), surat keterangan tidak mampu (SKTM), surat domisili, pengantar nikah, hingga surat kepemilikan ternak tanpa antre.
                    </p>
                </div>
                <a href="#layanan" class="inline-flex items-center gap-2 text-xs font-bold text-emerald-600 hover:text-emerald-700">
                    Lihat Daftar Surat & Syarat &rarr;
                </a>
            </div>

            <!-- Pilar 2: Pengaduan Warga -->
            <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/80 hover:border-amber-300 hover:shadow-md transition-all flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-xl mb-4">
                        <svg class="w-6 h-6 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Lapor Pengaduan & Aspirasi</h3>
                    <p class="text-xs text-slate-600 leading-relaxed mb-4">
                        Laporkan kendala distribusi pupuk subsidi, pompa air sawah, kerusakan jalan rabat antar-dusun, atau masukan pelayanan balai desa langsung ke pamong.
                    </p>
                </div>
                <a href="{{ route('warga.pengaduan.create') }}" class="inline-flex items-center gap-2 text-xs font-bold text-amber-700 hover:text-amber-800">
                    Buat Laporan Baru &rarr;
                </a>
            </div>

            <!-- Pilar 3: Transparansi Bansos -->
            <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/80 hover:border-teal-300 hover:shadow-md transition-all flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 rounded-2xl bg-teal-100 text-teal-700 flex items-center justify-center font-bold text-xl mb-4">
                        <svg class="w-6 h-6 text-teal-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Program Bantuan Sosial (Bansos)</h3>
                    <p class="text-xs text-slate-600 leading-relaxed mb-4">
                        Keterbukaan informasi penyaluran BLT Dana Desa (BLT-DD), Bantuan Cadangan Pangan Beras Bulog, bantuan bibit pertanian, dan posyandu stunting.
                    </p>
                </div>
                <a href="{{ route('warga.informasi.bansos') }}" class="inline-flex items-center gap-2 text-xs font-bold text-teal-700 hover:text-teal-800">
                    Cek Daftar Bansos Aktif &rarr;
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Section Layanan Surat -->
<section id="layanan" class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto space-y-2 mb-12">
            <span class="text-xs font-bold tracking-wider text-emerald-600 uppercase">Layanan Administrasi Surat</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Jenis Surat Yang Dapat Diajukan Online</h2>
            <p class="text-slate-600 text-xs sm:text-sm">Pilih jenis surat yang Anda butuhkan, siapkan persyaratan berkas, dan ajukan langsung dari HP atau komputer.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($jenisSurat as $surat)
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs hover:shadow-md transition-all flex flex-col justify-between group">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                                {{ $surat->kode }}
                            </span>
                            <span class="text-xs text-slate-500 font-medium flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $surat->estimasi_waktu }}
                            </span>
                        </div>

                        <h3 class="text-base font-bold text-slate-900 group-hover:text-emerald-600 transition-colors mb-2">
                            {{ $surat->nama }}
                        </h3>

                        <p class="text-slate-600 text-xs leading-relaxed mb-4">
                            {{ $surat->deskripsi }}
                        </p>

                        <div class="space-y-2 mb-6">
                            <h4 class="text-[11px] font-bold text-slate-700 uppercase tracking-wider">Persyaratan Berkas:</h4>
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

<!-- Section Warta & Berita Desa Terkini -->
@if($beritaTerbaru->count() > 0)
<section id="warta" class="py-16 bg-white border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-10">
            <div>
                <span class="text-xs font-bold tracking-wider text-emerald-600 uppercase">Warta Desa Rombiyah Barat</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">Kabar & Agenda Kegiatan Desa</h2>
            </div>
            <a href="{{ route('warga.informasi.index') }}" class="mt-4 md:mt-0 text-xs font-bold text-emerald-600 hover:text-emerald-700 inline-flex items-center gap-1">
                Lihat Semua Warta &rarr;
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($beritaTerbaru as $item)
                <div class="bg-slate-50 rounded-3xl p-6 border border-slate-200/80 flex flex-col justify-between hover:shadow-md transition-all">
                    <div>
                        <div class="flex items-center justify-between text-xs text-slate-500 mb-3">
                            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-slate-200 text-slate-700">
                                {{ $item->kategori_label }}
                            </span>
                            <span>{{ $item->published_at ? $item->published_at->format('d M Y') : '' }}</span>
                        </div>
                        <h3 class="font-bold text-slate-900 text-sm mb-2 hover:text-emerald-600 transition-colors">
                            <a href="{{ route('warga.berita.detail', $item->slug) }}">{{ $item->judul }}</a>
                        </h3>
                        <p class="text-xs text-slate-600 leading-relaxed mb-4">
                            {{ Str::limit($item->ringkasan ?? strip_tags($item->konten), 120) }}
                        </p>
                    </div>
                    <a href="{{ route('warga.berita.detail', $item->slug) }}" class="text-xs font-bold text-emerald-600 hover:underline">
                        Baca Selengkapnya &rarr;
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Section Struktur Pamong & 5 Dusun -->
<section id="profil" class="py-20 bg-gradient-to-b from-slate-50 via-white to-slate-50 border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto space-y-3 mb-16">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold uppercase tracking-wider">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                Struktur Organisasi & Tata Kelola
            </div>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900">
                Bagan Hierarki Pemerintahan <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-teal-600">Desa Rombiyah Barat</span>
            </h2>
            <p class="text-slate-600 text-xs sm:text-sm leading-relaxed">
                Alur kepemimpinan terintegrasi di bawah Kepala Desa <strong>Farhah</strong> bersama perangkat sekretariat, pelaksana teknis, dan 5 Kepala Dusun untuk melayani seluruh masyarakat.
            </p>
        </div>

        @php
            $kades = $perangkatDesa->first(function($p) {
                return str_contains(strtolower($p->jabatan), 'kepala desa') && !str_contains(strtolower($p->jabatan), 'dusun');
            }) ?? $perangkatDesa->first();

            $sekretariat = $perangkatDesa->filter(function($p) use ($kades) {
                $isKades = $kades && $p->id === $kades->id;
                $isKasun = str_contains(strtolower($p->jabatan), 'kepala dusun') || str_contains(strtolower($p->jabatan), 'kasun');
                return !$isKades && !$isKasun;
            });

            $kepalaDusun = $perangkatDesa->filter(function($p) {
                return str_contains(strtolower($p->jabatan), 'kepala dusun') || str_contains(strtolower($p->jabatan), 'kasun');
            });
        @endphp

        <!-- Flowchart Container -->
        <div class="relative bg-slate-900/5 backdrop-blur-sm rounded-3xl p-6 sm:p-10 border border-slate-200/80 shadow-sm overflow-hidden">
            
            <!-- LEVEL 1: KEPALA DESA & MITRA STRATEGIS -->
            <div class="relative z-10 flex flex-col items-center">
                <span class="text-[11px] font-extrabold tracking-widest text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full uppercase mb-4 border border-emerald-200">
                    Level 1 &bull; Pimpinan Puncak & Mitra Desa
                </span>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center w-full max-w-4xl">
                    
                    <!-- Mitra: BPD -->
                    <div class="order-2 md:order-1 bg-white p-4 rounded-2xl border-2 border-dashed border-slate-300 text-center shadow-xs hover:border-slate-400 transition-all">
                        <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center font-bold text-base mx-auto mb-2">
                            <svg class="w-6 h-6 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h5m-5 0v-4m0 4h5m-5 0v-4m0 0h-5m5 0V7"></path>
                            </svg>
                        </div>
                        <h4 class="font-bold text-xs text-slate-900">Badan Permusyawaratan Desa</h4>
                        <span class="text-[10px] font-semibold text-slate-500 block">Mitra Pengawasan & Aspirasi</span>
                    </div>

                    <!-- KEPALA DESA (Center Node with Photo) -->
                    @if($kades)
                    <div class="order-1 md:order-2 bg-gradient-to-b from-emerald-600 to-teal-700 text-white p-6 rounded-3xl text-center shadow-xl shadow-emerald-600/25 border-2 border-emerald-400 transform hover:-translate-y-1 transition-all duration-300 relative group">
                        <div class="absolute -top-3 left-1/2 -translate-x-1/2 px-3 py-0.5 rounded-full bg-amber-400 text-slate-900 text-[10px] font-black uppercase tracking-wider shadow-sm">
                            Kepala Desa
                        </div>
                        
                        <div class="w-24 h-24 rounded-2xl overflow-hidden border-2 border-white/80 shadow-lg mx-auto mb-3.5 bg-slate-100">
                            <img src="{{ $kades->foto_url }}" alt="{{ $kades->nama }}" class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-300">
                        </div>

                        <h3 class="font-extrabold text-lg text-white leading-tight">{{ $kades->nama }}</h3>
                        <p class="text-xs text-emerald-100 font-medium mt-0.5">{{ $kades->jabatan }}</p>
                        @if($kades->nip_atau_nomor)
                            <div class="mt-3 pt-3 border-t border-white/20 text-[11px] text-emerald-100 flex items-center justify-center gap-1">
                                <span>NIP: {{ $kades->nip_atau_nomor }}</span>
                            </div>
                        @endif
                    </div>
                    @endif

                    <!-- Mitra: BUMDes Kencana & PKK -->
                    <div class="order-3 bg-white p-4 rounded-2xl border-2 border-dashed border-slate-300 text-center shadow-xs hover:border-slate-400 transition-all">
                        <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold text-base mx-auto mb-2">
                            <svg class="w-6 h-6 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <h4 class="font-bold text-xs text-slate-900">BUMDes Kencana & PKK</h4>
                        <span class="text-[10px] font-semibold text-slate-500 block">Unit Ekonomi & Pemberdayaan</span>
                    </div>
                </div>
            </div>

            <!-- Flow Connector 1 -> 2 (Vertical Animated Arrow) -->
            <div class="flex justify-center my-4 relative">
                <div class="flex flex-col items-center">
                    <div class="w-0.5 h-10 bg-gradient-to-b from-emerald-500 to-teal-500"></div>
                    <div class="w-3 h-3 rounded-full bg-emerald-500 animate-ping -mt-1.5"></div>
                    <svg class="w-5 h-5 text-teal-600 -mt-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>

            <!-- LEVEL 2: SEKRETARIAT & UNSUR STAF / PELAKSANA TEKNIS -->
            @if($sekretariat->count() > 0)
            <div class="relative z-10 flex flex-col items-center">
                <span class="text-[11px] font-extrabold tracking-widest text-teal-700 bg-teal-50 px-3 py-1 rounded-full uppercase mb-4 border border-teal-200">
                    Level 2 &bull; Sekretariat Desa & Pelaksana Teknis
                </span>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 w-full max-w-5xl">
                    @foreach($sekretariat as $staf)
                        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm text-center hover:border-teal-400 hover:shadow-md transition-all group">
                            <div class="w-16 h-16 rounded-2xl overflow-hidden border-2 border-teal-200 shadow-xs mx-auto mb-2 bg-slate-100">
                                <img src="{{ $staf->foto_url }}" alt="{{ $staf->nama }}" class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform">
                            </div>
                            <h4 class="font-bold text-xs text-slate-900 leading-snug">{{ $staf->nama }}</h4>
                            <span class="inline-block px-2 py-0.5 rounded-md text-[10px] font-bold bg-teal-50 text-teal-700 my-1">
                                {{ $staf->jabatan }}
                            </span>
                            <p class="text-[10px] text-slate-500">{{ $staf->wilayah_tugas ?? 'Kantor Balai Desa' }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Flow Connector 2 -> 3 (Branching Connectors) -->
            <div class="flex justify-center my-4 relative">
                <div class="flex flex-col items-center">
                    <div class="w-0.5 h-10 bg-gradient-to-b from-teal-500 to-emerald-500"></div>
                    <div class="w-3 h-3 rounded-full bg-teal-500 animate-ping -mt-1.5"></div>
                    <svg class="w-5 h-5 text-emerald-600 -mt-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>

            <!-- LEVEL 3: UNSUR KEWILAYAHAN (KEPALA DUSUN) -->
            @if($kepalaDusun->count() > 0)
            <div class="relative z-10 flex flex-col items-center">
                <span class="text-[11px] font-extrabold tracking-widest text-emerald-800 bg-emerald-100 px-3.5 py-1 rounded-full uppercase mb-4 border border-emerald-300">
                    Level 3 &bull; Unsur Kewilayahan (Kepala Dusun)
                </span>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 w-full">
                    @foreach($kepalaDusun as $kasun)
                        <div class="bg-white p-5 rounded-2xl border-2 border-emerald-200/80 shadow-xs hover:border-emerald-500 hover:shadow-md transition-all text-center group">
                            <div class="w-14 h-14 rounded-2xl overflow-hidden border-2 border-emerald-300 shadow-xs mx-auto mb-2 bg-slate-100">
                                <img src="{{ $kasun->foto_url }}" alt="{{ $kasun->nama }}" class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform">
                            </div>
                            <span class="text-[10px] font-black text-emerald-700 uppercase tracking-wider block">{{ $kasun->wilayah_tugas ?? $kasun->jabatan }}</span>
                            <h4 class="font-bold text-xs text-slate-900 mt-1">{{ $kasun->nama }}</h4>
                            <span class="text-[10px] text-slate-500 font-medium block">{{ $kasun->jabatan }}</span>
                            @if($kasun->telepon)
                                <p class="text-[10px] text-slate-500 mt-2 pt-2 border-t border-slate-100 leading-relaxed">
                                    Telp: {{ $kasun->telepon }}
                                </p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>

        <!-- Info Balai Desa -->
        <div class="mt-12 bg-white rounded-3xl p-8 border border-slate-200 shadow-sm grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="space-y-2">
                <span class="text-xs font-bold text-emerald-600 uppercase">Kantor Balai Desa</span>
                <h3 class="text-base font-bold text-slate-900">Alamat & Jam Operasional</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    {{ $profil->kontak['alamat_kantor'] ?? 'Jl. Raya Ganding - Rombiyah Barat No. 01, Kec. Ganding, Kab. Sumenep, Jawa Timur 69462' }}
                </p>
                <div class="pt-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 text-xs font-semibold">
                        Kontak/WA: {{ $profil->kontak['whatsapp'] ?? '082334567890' }}
                    </span>
                </div>
            </div>

            <div class="space-y-2">
                <span class="text-xs font-bold text-emerald-600 uppercase">Jam Pelayanan Tatap Muka</span>
                <ul class="text-xs text-slate-600 space-y-1.5">
                    <li class="flex justify-between border-b border-slate-100 pb-1"><span>Senin - Kamis:</span> <strong class="text-slate-800">08:00 - 15:00 WIB</strong></li>
                    <li class="flex justify-between border-b border-slate-100 pb-1"><span>Jumat:</span> <strong class="text-slate-800">08:00 - 11:30 WIB</strong></li>
                    <li class="flex justify-between border-b border-slate-100 pb-1"><span>Sabtu - Minggu:</span> <span class="text-rose-600 font-semibold">Libur (Layanan Web 24 Jam)</span></li>
                </ul>
            </div>

            <div class="space-y-2">
                <span class="text-xs font-bold text-emerald-600 uppercase">Lembaga Ekonomi & Kemitraan</span>
                <h4 class="font-bold text-slate-900 text-xs">BUMDes Kencana & Poktan Desa</h4>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Mendukung ketahanan pangan, penyediaan sarana produksi pertanian (pupuk & benih tembakau/jagung), serta layanan pembayaran resmi.
                </p>
            </div>
        </div>
    </div>
</section>
@endsection
