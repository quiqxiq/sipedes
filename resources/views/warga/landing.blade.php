@extends('layouts.app')

@section('title', 'SIPEDES — Pelayanan Terpadu Desa Rombiya Barat, Ganding, Sumenep')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-emerald-950 via-teal-900 to-slate-900 text-white overflow-hidden py-16 lg:py-24">
    <div class="absolute inset-0 opacity-15 bg-[radial-gradient(#10b981_1px,transparent_1px)] [background-size:20px_20px]"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                <div class="flex items-center justify-center lg:justify-start gap-4">
                    <img src="{{ asset('images/logo.png') }}" alt="Lambang Resmi Desa Rombiya Barat" class="w-16 h-16 sm:w-20 sm:h-20 object-contain drop-shadow-xl rounded-2xl bg-white/10 p-1.5 border border-white/20">
                    <div class="space-y-1 text-left">
                        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-emerald-300 text-xs font-semibold backdrop-blur-md">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            DESA ROMBIYA Barat &bull; Kec. Ganding &bull; Kab. Sumenep
                        </div>
                        <div class="text-[11px] text-emerald-200/90 font-medium tracking-wide">
                            SIPEDES &bull; Sistem Pelayanan Desa Digital Terpadu
                        </div>
                    </div>
                </div>

                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-tight">
                    Portal Pelayanan Terpadu & Informasi Digital <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-teal-300 to-cyan-200">Desa Rombiya Barat</span>
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

                    <a href="#tentang-sipedes" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl font-bold text-sm text-white bg-emerald-700/80 hover:bg-emerald-600/80 border border-emerald-500/50 backdrop-blur-md shadow-md transition-all">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Apa itu SIPEDES?
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
                    <h3 class="font-bold text-white text-sm">Cek Penerima Bansos</h3>
                    <p class="text-xs text-slate-300 mt-1">Cek NIK KPM untuk PKH, Lansia, BLT-DD, & Beras CBP 10 kg.</p>
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

<!-- Stats Bar Wilayah Desa & Kependudukan -->
<section class="bg-gradient-to-r from-emerald-950 via-emerald-900 to-teal-950 text-white py-6 border-y border-emerald-800/80 shadow-inner">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-5 gap-6 text-center">
            <div class="border-b md:border-b-0 md:border-r border-emerald-800/60 pb-4 md:pb-0">
                <div class="text-2xl sm:text-3xl font-extrabold text-emerald-300">1.403</div>
                <div class="text-xs text-emerald-100/90 font-medium mt-0.5">Total Penduduk (Disdukcapil)</div>
                <div class="text-[10px] text-emerald-200/70">Rentang 1.403 – 1.456 Jiwa</div>
            </div>
            <div class="border-b md:border-b-0 md:border-r border-emerald-800/60 pb-4 md:pb-0">
                <div class="text-xl sm:text-2xl font-bold text-white flex items-center justify-center gap-1">
                    <span class="text-sky-300">652 L</span>
                    <span class="text-emerald-400">&bull;</span>
                    <span class="text-pink-300">751 P</span>
                </div>
                <div class="text-xs text-emerald-100/90 font-medium mt-0.5">Laki-laki &amp; Perempuan</div>
                <div class="text-[10px] text-emerald-200/70">Proporsi 46,5% : 53,5%</div>
            </div>
            <div class="border-b md:border-b-0 md:border-r border-emerald-800/60 pb-4 md:pb-0">
                <div class="text-2xl sm:text-3xl font-extrabold text-amber-300">560</div>
                <div class="text-xs text-emerald-100/90 font-medium mt-0.5">Kepala Keluarga (KK)</div>
                <div class="text-[10px] text-emerald-200/70">5 Dusun &bull; 20 RT &bull; 5 RW</div>
            </div>
            <div class="border-b md:border-b-0 md:border-r border-emerald-800/60 pb-4 md:pb-0">
                <div class="inline-flex items-center justify-center gap-1 text-2xl sm:text-3xl font-extrabold text-cyan-300">
                    <span class="w-2 h-2 rounded-full bg-cyan-400 animate-ping"></span>
                    {{ number_format($totalWargaTerdaftar) }}
                </div>
                <div class="text-xs text-emerald-100/90 font-medium mt-0.5">Warga Terdaftar SIPEDES</div>
                <div class="text-[10px] text-cyan-200/80 font-semibold">Otomatis dari Dashboard</div>
            </div>
            <div>
                <div class="text-2xl sm:text-3xl font-extrabold text-emerald-300">{{ number_format($totalSuratDisetujui) }}</div>
                <div class="text-xs text-emerald-100/90 font-medium mt-0.5">Surat Resmi Diterbitkan</div>
                <div class="text-[10px] text-emerald-200/70">{{ number_format($totalPengaduanSelesai) }} Laporan Ditangani</div>
            </div>
        </div>
    </div>
</section>

<!-- Section: Demografi & Statistik Kependudukan Resmi Desa Rombiya Barat -->
<section id="demografi" class="py-16 bg-slate-900 text-white relative overflow-hidden border-b border-slate-800">
    <!-- Ambient Background Glow -->
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#10b981_1px,transparent_1px)] [background-size:24px_24px]"></div>
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto space-y-3 mb-12">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-500/15 border border-emerald-400/30 text-emerald-300 text-xs font-bold uppercase tracking-wider backdrop-blur-md">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                Data Resmi Kependudukan &bull; Disdukcapil Sumenep
            </div>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight">
                Statistik Demografi &amp; Kependudukan <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-teal-300 to-cyan-200">Desa Rombiya Barat</span>
            </h2>
            <p class="text-slate-300 text-xs sm:text-sm leading-relaxed max-w-2xl mx-auto">
                Kecamatan Ganding, Kabupaten Sumenep. Data tervalidasi resmi berdasarkan Dinas Kependudukan dan Pencatatan Sipil (Disdukcapil) serta terintegrasi otomatis dengan akun pelayanan publik digital SIPEDES.
            </p>
        </div>

        <!-- 4 Stat Cards Utama -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            
            <!-- Card 1: Total Penduduk -->
            <div class="bg-white/5 hover:bg-white/10 backdrop-blur-md border border-white/10 rounded-3xl p-6 transition-all duration-300 hover:border-emerald-500/50 hover:shadow-xl hover:shadow-emerald-500/10 group">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                        Disdukcapil
                    </span>
                </div>
                <div class="text-3xl sm:text-4xl font-black text-white tracking-tight">1.403 <span class="text-sm font-semibold text-emerald-300">Jiwa</span></div>
                <h3 class="text-sm font-bold text-slate-200 mt-1">Total Jumlah Penduduk</h3>
                <p class="text-xs text-slate-400 mt-2 leading-relaxed">
                    Rentang data resmi: <strong>1.403 – 1.456 jiwa</strong> tercatat di administrasi kependudukan Disdukcapil Kab. Sumenep.
                </p>
            </div>

            <!-- Card 2: Laki-laki -->
            <div class="bg-white/5 hover:bg-white/10 backdrop-blur-md border border-white/10 rounded-3xl p-6 transition-all duration-300 hover:border-sky-500/50 hover:shadow-xl hover:shadow-sky-500/10 group">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-sky-500/20 text-sky-400 flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-sky-500/20 text-sky-300 border border-sky-500/30">
                        46,5%
                    </span>
                </div>
                <div class="text-3xl sm:text-4xl font-black text-sky-300 tracking-tight">652 <span class="text-sm font-semibold text-slate-300">Jiwa</span></div>
                <h3 class="text-sm font-bold text-slate-200 mt-1">Penduduk Laki-laki</h3>
                <p class="text-xs text-slate-400 mt-2 leading-relaxed">
                    Warga laki-laki yang tersebar di 5 dusun dan mendukung produktivitas sektor pertanian tembakau &amp; UMKM desa.
                </p>
            </div>

            <!-- Card 3: Perempuan -->
            <div class="bg-white/5 hover:bg-white/10 backdrop-blur-md border border-white/10 rounded-3xl p-6 transition-all duration-300 hover:border-pink-500/50 hover:shadow-xl hover:shadow-pink-500/10 group">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-pink-500/20 text-pink-400 flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-pink-500/20 text-pink-300 border border-pink-500/30">
                        53,5%
                    </span>
                </div>
                <div class="text-3xl sm:text-4xl font-black text-pink-300 tracking-tight">751 <span class="text-sm font-semibold text-slate-300">Jiwa</span></div>
                <h3 class="text-sm font-bold text-slate-200 mt-1">Penduduk Perempuan</h3>
                <p class="text-xs text-slate-400 mt-2 leading-relaxed">
                    Warga perempuan yang aktif dalam kegiatan PKK, pembinaan keluarga, posyandu terpadu, dan industri olahan pangan.
                </p>
            </div>

            <!-- Card 4: Kepala Keluarga -->
            <div class="bg-white/5 hover:bg-white/10 backdrop-blur-md border border-white/10 rounded-3xl p-6 transition-all duration-300 hover:border-amber-500/50 hover:shadow-xl hover:shadow-amber-500/10 group">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-500/20 text-amber-400 flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </div>
                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">
                        5 Dusun
                    </span>
                </div>
                <div class="text-3xl sm:text-4xl font-black text-amber-300 tracking-tight">560 <span class="text-sm font-semibold text-slate-300">KK</span></div>
                <h3 class="text-sm font-bold text-slate-200 mt-1">Jumlah Kepala Keluarga</h3>
                <p class="text-xs text-slate-400 mt-2 leading-relaxed">
                    Sekitar 560 Kepala Keluarga (KK) dengan rata-rata 2,5 – 2,6 jiwa per rumah tangga di seluruh rukun tetangga.
                </p>
            </div>
        </div>

        <!-- Banner Warga Terdaftar di SIPEDES (Sinkronisasi Otomatis dari Admin Dashboard) -->
        <div class="bg-gradient-to-r from-emerald-900/80 via-teal-900/70 to-slate-900/80 border border-emerald-500/40 rounded-3xl p-6 sm:p-8 backdrop-blur-xl mb-8 relative overflow-hidden shadow-2xl">
            <div class="absolute right-0 top-0 -bottom-10 w-1/3 bg-radial from-emerald-500/10 to-transparent pointer-events-none"></div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">
                <div class="lg:col-span-6 space-y-3">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-cyan-500/20 border border-cyan-400/40 text-cyan-300 text-xs font-bold">
                        <span class="w-2.5 h-2.5 rounded-full bg-cyan-400 animate-ping"></span>
                        Tersinkronisasi Real-Time dengan Dashboard Admin
                    </div>
                    <h3 class="text-xl sm:text-2xl font-black text-white">
                        Layanan Terpadu: Warga Terdaftar &amp; Surat Diterbitkan
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed max-w-xl">
                        Jumlah warga terdaftar dan total surat resmi yang diterbitkan dihitung secara otomatis dari database sistem. Setiap penambahan warga baru atau persetujuan surat di dashboard admin langsung memperbarui data di halaman ini secara instan.
                    </p>
                    <div class="flex flex-wrap items-center gap-3 pt-1 text-xs text-emerald-200">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Verifikasi NIK Resmi
                        </span>
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Otomatis dari Dashboard
                        </span>
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Dokumen Resmi Valid
                        </span>
                    </div>
                </div>

                <div class="lg:col-span-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Box 1: Warga Terdaftar Live Counter -->
                    <div class="bg-black/40 border border-cyan-400/30 rounded-2xl p-5 text-center shadow-lg flex flex-col justify-between hover:border-cyan-400/60 transition-all group">
                        <div>
                            <div class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-cyan-500/20 text-cyan-300 text-[10px] font-extrabold uppercase tracking-wider mb-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 animate-pulse"></span>
                                Warga Terdaftar
                            </div>
                            <div class="text-3xl sm:text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-emerald-300 to-cyan-300 my-1">
                                {{ number_format($totalWargaTerdaftar) }}
                            </div>
                            <span class="text-[11px] text-slate-400 block">dari {{ number_format($totalPengguna) }} Total Pengguna Sistem</span>
                        </div>
                        
                        @guest
                            <a href="{{ route('warga.register') }}" class="mt-3.5 inline-flex items-center justify-center gap-1.5 w-full px-3 py-2 rounded-xl bg-gradient-to-r from-cyan-500 to-teal-500 hover:from-cyan-400 hover:to-teal-400 text-slate-950 text-xs font-bold transition-all shadow-md shadow-cyan-500/20">
                                <span>Daftar Akun Warga</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        @else
                            <a href="{{ route('warga.dashboard') }}" class="mt-3.5 inline-flex items-center justify-center gap-1.5 w-full px-3 py-2 rounded-xl bg-cyan-500/20 hover:bg-cyan-500/30 text-cyan-200 text-xs font-bold transition-all border border-cyan-400/40">
                                <span>Dashboard Warga</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        @endguest
                    </div>

                    <!-- Box 2: Surat Diterbitkan Live Counter -->
                    <div class="bg-black/40 border border-emerald-400/30 rounded-2xl p-5 text-center shadow-lg flex flex-col justify-between hover:border-emerald-400/60 transition-all group">
                        <div>
                            <div class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 text-[10px] font-extrabold uppercase tracking-wider mb-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                Surat Diterbitkan
                            </div>
                            <div class="text-3xl sm:text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-teal-300 to-emerald-300 my-1">
                                {{ number_format($totalSuratDisetujui) }}
                            </div>
                            <span class="text-[11px] text-slate-400 block">Surat Resmi Disetujui &bull; Siap Unduh</span>
                        </div>
                        
                        <a href="#layanan" class="mt-3.5 inline-flex items-center justify-center gap-1.5 w-full px-3 py-2 rounded-xl bg-emerald-600/80 hover:bg-emerald-500 text-white text-xs font-bold transition-all border border-emerald-400/40 shadow-md shadow-emerald-600/20">
                            <span>Ajukan Surat Online</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Visual Bar Proporsi Gender & Wilayah 5 Dusun -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
            
            <!-- Left: Proporsi Gender Visual Bar -->
            <div class="lg:col-span-6 bg-white/5 border border-white/10 rounded-3xl p-6 sm:p-7 backdrop-blur-md flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="text-sm font-bold text-white flex items-center gap-2">
                            <span class="p-1 rounded-lg bg-sky-500/20 text-sky-400">⚖️</span>
                            Proporsi Gender Penduduk
                        </h4>
                        <span class="text-xs text-slate-400">1.403 Jiwa</span>
                    </div>
                    <p class="text-xs text-slate-400 mb-5 leading-relaxed">
                        Keseimbangan komposisi demografi laki-laki (652 jiwa) dan perempuan (751 jiwa) di Desa Rombiya Barat.
                    </p>

                    <!-- Comparative Progress Bar -->
                    <div class="space-y-2 mb-6">
                        <div class="h-5 w-full bg-slate-800 rounded-full overflow-hidden p-0.5 flex border border-white/10 shadow-inner">
                            <div class="h-full bg-gradient-to-r from-sky-500 to-indigo-500 rounded-l-full transition-all duration-1000 relative group" style="width: 46.5%">
                                <span class="sr-only">Laki-laki 46,5%</span>
                            </div>
                            <div class="h-full bg-gradient-to-r from-rose-500 to-pink-500 rounded-r-full transition-all duration-1000 relative group" style="width: 53.5%">
                                <span class="sr-only">Perempuan 53,5%</span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center text-xs font-bold pt-1">
                            <div class="flex items-center gap-2 text-sky-300">
                                <span class="w-3 h-3 rounded-full bg-sky-400"></span>
                                <span>Laki-laki: 652 Jiwa (46,5%)</span>
                            </div>
                            <div class="flex items-center gap-2 text-pink-300">
                                <span>Perempuan: 751 Jiwa (53,5%)</span>
                                <span class="w-3 h-3 rounded-full bg-pink-400"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Info Tambahan -->
                <div class="p-4 rounded-2xl bg-slate-800/60 border border-white/5 text-xs text-slate-300 leading-relaxed">
                    <span class="text-emerald-300 font-bold">💡 Analisis Demografi:</span>
                    Rasio jenis kelamin menunjukkan struktur kependudukan yang sangat produktif dengan partisipasi aktif kaum perempuan dan laki-laki pada sektor agraria, pengolahan singkong, dan pendidikan kemasyarakatan.
                </div>
            </div>

            <!-- Right: Sebaran 5 Dusun Administrasi -->
            <div class="lg:col-span-6 bg-white/5 border border-white/10 rounded-3xl p-6 sm:p-7 backdrop-blur-md flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="text-sm font-bold text-white flex items-center gap-2">
                            <span class="p-1 rounded-lg bg-emerald-500/20 text-emerald-400">🏡</span>
                            Wilayah Kewilayahan 5 Dusun
                        </h4>
                        <span class="text-xs text-emerald-300 font-semibold">20 RT &bull; 5 RW</span>
                    </div>
                    <p class="text-xs text-slate-400 mb-4 leading-relaxed">
                        Desa Rombiya Barat terbagi atas 5 wilayah dusun strategis yang dipimpin masing-masing Kepala Dusun (Kasun):
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 mb-4">
                        <div class="p-3 rounded-xl bg-slate-800/80 border border-white/5 flex items-center justify-between">
                            <div>
                                <span class="text-xs font-bold text-white block">Dusun Kebunan</span>
                                <span class="text-[10px] text-slate-400">Pertanian Padi &amp; Tembakau</span>
                            </div>
                            <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-500/20 text-emerald-300">4 RT</span>
                        </div>

                        <div class="p-3 rounded-xl bg-slate-800/80 border border-white/5 flex items-center justify-between">
                            <div>
                                <span class="text-xs font-bold text-white block">Dusun Buwa</span>
                                <span class="text-[10px] text-slate-400">Pemukiman &amp; Hortikultura</span>
                            </div>
                            <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-500/20 text-emerald-300">3 RT</span>
                        </div>

                        <div class="p-3 rounded-xl bg-slate-800/80 border border-white/5 flex items-center justify-between">
                            <div>
                                <span class="text-xs font-bold text-white block">Dusun Tanodung</span>
                                <span class="text-[10px] text-slate-400">Peternakan Sapi &amp; Pangan</span>
                            </div>
                            <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-500/20 text-emerald-300">4 RT</span>
                        </div>

                        <div class="p-3 rounded-xl bg-slate-800/80 border border-white/5 flex items-center justify-between">
                            <div>
                                <span class="text-xs font-bold text-white block">Dusun Rombiya</span>
                                <span class="text-[10px] text-slate-400">Pusat Desa &amp; Pendidikan</span>
                            </div>
                            <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-500/20 text-emerald-300">4 RT</span>
                        </div>

                        <div class="p-3 rounded-xl bg-slate-800/80 border border-white/5 flex items-center justify-between sm:col-span-2">
                            <div>
                                <span class="text-xs font-bold text-white block">Dusun Kalampok</span>
                                <span class="text-[10px] text-slate-400">Sentra UMKM Keripik &amp; Olahan Singkong TTG</span>
                            </div>
                            <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-500/20 text-emerald-300">5 RT</span>
                        </div>
                    </div>
                </div>

                <div class="text-[11px] text-slate-400 flex items-center justify-between pt-2 border-t border-white/5">
                    <span>Total Satuan Lingkungan: <strong>20 Rukun Tetangga (RT)</strong></span>
                    <span class="text-emerald-300 font-semibold">5 Rukun Warga (RW)</span>
                </div>
            </div>
        </div>

        <!-- Box Rujukan Sumber Resmi Disdukcapil Sumenep -->
        <div class="mt-8 p-5 rounded-2xl bg-emerald-950/60 border border-emerald-500/30 text-xs text-slate-300 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div class="space-y-1">
                <div class="flex items-center gap-2 text-emerald-300 font-bold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    Sumber Resmi &amp; Akuntabilitas Data Kependudukan
                </div>
                <p class="text-slate-400 text-[11px] leading-relaxed">
                    Data kependudukan di atas mengacu pada publikasi resmi Dinas Kependudukan dan Pencatatan Sipil (Disdukcapil) Pemerintah Kabupaten Sumenep.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2 shrink-0">
                <a href="https://disdukcapil.sumenepkab.go.id/" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-800/60 hover:bg-emerald-700/60 border border-emerald-500/40 text-white text-[11px] font-semibold transition-all">
                    <svg class="w-3.5 h-3.5 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    Disdukcapil Sumenep
                </a>
                <a href="http://disdukcapil.sumenepkab.go.id/storage/uploads/file/233-801d6371-f999-4735-8337-c4056a20d4c4.pdf" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-800/60 hover:bg-emerald-700/60 border border-emerald-500/40 text-white text-[11px] font-semibold transition-all">
                    <svg class="w-3.5 h-3.5 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    Dokumen PDF [1]
                </a>
                <a href="https://disdukcapil.sumenepkab.go.id/storage/uploads/file/54-a14ff911-8fde-45fe-bb54-f7663cf17613.pdf" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-800/60 hover:bg-emerald-700/60 border border-emerald-500/40 text-white text-[11px] font-semibold transition-all">
                    <svg class="w-3.5 h-3.5 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    Dokumen PDF [2]
                </a>
                <a href="https://id.wikipedia.org/wiki/Rombiya_Barat,_Ganding,_Sumenep" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-800/60 hover:bg-emerald-700/60 border border-emerald-500/40 text-white text-[11px] font-semibold transition-all">
                    <svg class="w-3.5 h-3.5 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Wikipedia [3]
                </a>
            </div>
        </div>

    </div>
</section>

<!-- Section: Mengenal SIPEDES (Sistem Pelayanan Desa) -->
<section id="tentang-sipedes" class="py-16 bg-gradient-to-b from-slate-50 to-white relative overflow-hidden border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            <!-- Left Column: Logo & Visual Badge -->
            <div class="lg:col-span-4 text-center lg:text-left flex flex-col items-center lg:items-start space-y-4">
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-emerald-600 to-teal-500 rounded-3xl blur-md opacity-25 group-hover:opacity-40 transition duration-300"></div>
                    <div class="relative bg-white p-5 rounded-3xl border border-slate-200 shadow-xl flex items-center justify-center">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo Resmi Desa Rombiya Barat" class="w-40 h-40 sm:w-48 sm:h-48 object-contain">
                    </div>
                </div>
                <div class="text-center lg:text-left space-y-1">
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-700 bg-emerald-100 px-3 py-1 rounded-full">Identitas Resmi</span>
                    <h3 class="text-base font-bold text-slate-800">DESA ROMBIYA Barat</h3>
                    <p class="text-xs text-slate-500">Kecamatan Ganding, Kabupaten Sumenep, Jawa Timur</p>
                </div>
            </div>

            <!-- Right Column: Detail Apa itu SIPEDES -->
            <div class="lg:col-span-8 space-y-6">
                <div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 uppercase tracking-wider mb-2">
                        💡 Mengenal Platform Desa Digital
                    </span>
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                        Apa Itu <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-teal-600">SIPEDES</span>?
                    </h2>
                    <p class="text-xs sm:text-sm font-semibold text-emerald-700 mt-1">
                        SIPEDES adalah singkatan dari <strong>Sistem Pelayanan Desa</strong>
                    </p>
                </div>

                <div class="prose prose-slate text-xs sm:text-sm text-slate-600 leading-relaxed space-y-3">
                    <p>
                        <strong>SIPEDES (Sistem Pelayanan Desa)</strong> merupakan platform digital inovatif dan terpadu milik <strong>DESA ROMBIYA Barat</strong>, dirancang khusus untuk memodernisasi tata kelola birokrasi dan memudahkan masyarakat dalam mendapatkan pelayanan administrasi secara mandiri, transparan, cepat, dan akuntabel.
                    </p>
                    <p>
                        Dengan hadirnya SIPEDES, warga di 5 Dusun (Dusun Kebunan, Dusun Buwa, Dusun Tanodung, Dusun Rombiya, dan Dusun Kalampok) tidak lagi harus bolak-balik ke kantor Balai Desa hanya untuk menanyakan berkas persyaratan atau mengantre berjam-jam. Seluruh proses persuratan dapat diajukan secara online dari mana saja dan kapan saja.
                    </p>
                </div>

                <!-- 4 Keunggulan Utama SIPEDES -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                    <div class="p-4 rounded-2xl bg-white border border-slate-200 shadow-2xs space-y-1.5">
                        <div class="flex items-center gap-2 text-emerald-700 font-bold text-xs">
                            <span class="p-1.5 rounded-lg bg-emerald-100">📄</span>
                            <span>Pelayanan Persuratan Mandiri</span>
                        </div>
                        <p class="text-[11px] text-slate-500 leading-normal">
                            Pengajuan SKU, SKTM, Surat Domisili, Keterangan Usaha Tani, hingga Surat Kematian online dengan alur verifikasi resmi dan pelacakan status real-time.
                        </p>
                    </div>

                    <div class="p-4 rounded-2xl bg-white border border-slate-200 shadow-2xs space-y-1.5">
                        <div class="flex items-center gap-2 text-teal-700 font-bold text-xs">
                            <span class="p-1.5 rounded-lg bg-teal-100">🔍</span>
                            <span>Transparansi Bantuan Sosial (Bansos)</span>
                        </div>
                        <p class="text-[11px] text-slate-500 leading-normal">
                            Warga dapat mengecek kelayakan penerima manfaat program PKH, BLT Dana Desa, dan Beras CBP 10 kg secara transparan dan tepat sasaran berdasarkan NIK.
                        </p>
                    </div>

                    <div class="p-4 rounded-2xl bg-white border border-slate-200 shadow-2xs space-y-1.5">
                        <div class="flex items-center gap-2 text-amber-700 font-bold text-xs">
                            <span class="p-1.5 rounded-lg bg-amber-100">📢</span>
                            <span>Kanal Aspirasi & Pengaduan Warga</span>
                        </div>
                        <p class="text-[11px] text-slate-500 leading-normal">
                            Wadah resmi bagi warga untuk melaporkan kendala fasilitas umum, irigasi sawah, pupuk pertanian, atau jalan dusun yang langsung dipantau pamong desa.
                        </p>
                    </div>

                    <div class="p-4 rounded-2xl bg-white border border-slate-200 shadow-2xs space-y-1.5">
                        <div class="flex items-center gap-2 text-cyan-700 font-bold text-xs">
                            <span class="p-1.5 rounded-lg bg-cyan-100">🤖</span>
                            <span>Asisten Pintar AI Desa (Dify RAG)</span>
                        </div>
                        <p class="text-[11px] text-slate-500 leading-normal">
                            Didukung teknologi kecerdasan buatan (AI) berbasis dokumen pengetahuan desa yang siap menjawab pertanyaan syarat dan jam operasional 24 jam nonstop.
                        </p>
                    </div>
                </div>
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
            <p class="text-slate-600 text-xs sm:text-sm">DESA ROMBIYA Barat berkomitmen menghadirkan tata kelola pemerintahan yang terbuka, cepat, dan responsif.</p>
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
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Pengecekan & Transparansi Bansos</h3>
                    <p class="text-xs text-slate-600 leading-relaxed mb-4">
                        Cek status NIK penerima manfaat (KPM) untuk PKH, Lansia, BLT Dana Desa, Beras Bulog 10 kg, sembako, dan pupuk subsidi lengkap dengan rincian yang didapat.
                    </p>
                </div>
                <a href="{{ route('warga.informasi.bansos') }}" class="inline-flex items-center gap-2 text-xs font-bold text-teal-700 hover:text-teal-800">
                    Cek Status Penerima Bansos &rarr;
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
                            <ul class="space-y-1.5">
                                @forelse($surat->persyaratan_list as $syaratItem)
                                    <li class="text-xs text-slate-600 flex items-start gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-emerald-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span class="flex-1">
                                            {{ is_array($syaratItem) ? ($syaratItem['nama'] ?? '-') : $syaratItem }}
                                            @if(is_array($syaratItem) && !empty($syaratItem['wajib']))
                                                <span class="text-[10px] font-bold text-rose-500" title="Wajib Diunggah">*</span>
                                            @endif
                                        </span>
                                    </li>
                                @empty
                                    <li class="text-xs text-slate-400 italic">Tidak ada berkas khusus.</li>
                                @endforelse
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
                <span class="text-xs font-bold tracking-wider text-emerald-600 uppercase">Warta Desa Rombiya Barat</span>
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

        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto space-y-3 mb-16">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold uppercase tracking-wider">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                Struktur Organisasi & Tata Kelola
            </div>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900">
                Bagan Hierarki Pemerintahan <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-teal-600">Desa Rombiya Barat</span>
            </h2>
            <p class="text-slate-600 text-xs sm:text-sm leading-relaxed">
                Alur kepemimpinan terintegrasi di bawah Kepala Desa <strong>{{ $kades->nama ?? ($profil->kepala_desa ?? 'Kepala Desa') }}</strong> bersama perangkat sekretariat, pelaksana teknis, dan 5 Kepala Dusun untuk melayani seluruh masyarakat.
            </p>
        </div>

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

        <!-- Section Balai Desa & Pusat Pelayanan Terpadu -->
        <div class="mt-14 bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-12 items-stretch">
                <!-- Foto Balai Desa Rombiya Barat -->
                <div class="lg:col-span-5 relative min-h-[300px] lg:min-h-[420px] overflow-hidden group">
                    <img src="{{ asset('images/balai_desa.jpeg') }}" 
                         alt="Kantor Balai Desa Rombiya Barat, Kec. Ganding, Kab. Sumenep" 
                         class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-700 ease-out">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-900/20 to-transparent"></div>
                    
                    <div class="absolute top-4 left-4">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-600/90 text-white text-xs font-bold shadow-md backdrop-blur-sm">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h5m-5 0v-4m0 4h5m-5 0v-4m0 0h-5m5 0V7"></path>
                            </svg>
                            Kantor Balai Desa
                        </span>
                    </div>

                    <div class="absolute bottom-5 left-5 right-5 text-white">
                        <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md bg-amber-400/90 text-slate-900 text-[10px] font-black uppercase tracking-wider mb-1.5">
                            Gedung Utama Pelayanan
                        </div>
                        <h3 class="text-lg sm:text-xl font-extrabold text-white leading-tight drop-shadow-sm">
                            Balai Desa Rombiya Barat
                        </h3>
                        <p class="text-xs text-slate-200 mt-1 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Kecamatan Ganding, Kabupaten Sumenep
                        </p>
                    </div>
                </div>

                <!-- Informasi Detail Balai Desa -->
                <div class="lg:col-span-7 p-6 sm:p-8 lg:p-10 flex flex-col justify-between space-y-6">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-bold uppercase tracking-wider mb-3">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            Pusat Pelayanan & Administrasi Warga
                        </div>
                        <h3 class="text-xl sm:text-2xl font-extrabold text-slate-900">
                            Kantor Balai Desa Rombiya Barat
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600 mt-2 leading-relaxed">
                            Pusat koordinasi pemerintahan desa dan pelayanan masyarakat untuk 5 dusun (Kebunan, Buwa, Tanodung, Rombiya, dan Kalampok). Dilengkapi sarana musyawarah warga, posko BUMDes Kencana, dan layanan surat terpadu.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Alamat Kantor -->
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80">
                            <div class="flex items-center gap-2 text-xs font-bold text-slate-900 mb-1.5">
                                <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                Alamat & Lokasi
                            </div>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                {{ $profil->kontak['alamat_kantor'] ?? 'Jl. Raya Ganding - Rombiya Barat No. 01, Kec. Ganding, Kab. Sumenep, Jawa Timur 69462' }}
                            </p>
                        </div>

                        <!-- Jam Layanan Tatap Muka -->
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80">
                            <div class="flex items-center gap-2 text-xs font-bold text-slate-900 mb-1.5">
                                <div class="w-7 h-7 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                Jam Pelayanan Tatap Muka
                            </div>
                            <ul class="text-xs text-slate-600 space-y-1">
                                <li class="flex justify-between border-b border-slate-100 pb-0.5"><span>Senin - Kamis:</span> <strong class="text-slate-800">08:00 - 15:00 WIB</strong></li>
                                <li class="flex justify-between border-b border-slate-100 pb-0.5"><span>Jumat:</span> <strong class="text-slate-800">08:00 - 11:30 WIB</strong></li>
                                <li class="flex justify-between text-emerald-700 font-semibold"><span>Online (SIPEDES):</span> <span>24 Jam Nonstop</span></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Lembaga Kemitraan & Tombol WhatsApp -->
                    <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="text-xs text-slate-600 w-full sm:w-auto">
                            <span class="font-bold text-slate-800 block">Kemitraan & Sarana Pertanian:</span>
                            <span class="text-[11px] text-slate-500">BUMDes Kencana &bull; Poktan &bull; Posko Penyaluran Bansos</span>
                        </div>

                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profil->kontak['whatsapp'] ?? '082334567890') }}?text=Halo%20Pemerintah%20Desa%20Rombiya%20Barat,%20saya%20ingin%20bertanya%20mengenai%20layanan%20desa." 
                           target="_blank" 
                           class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold shadow-md shadow-emerald-600/20 transition-all">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86.173.086.274.072.375-.043.101-.116.433-.506.549-.68.116-.173.231-.144.39-.086s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.099.824z"/>
                            </svg>
                            Hubungi Balai Desa
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
