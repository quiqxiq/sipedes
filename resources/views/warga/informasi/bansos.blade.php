@extends('layouts.app')

@section('title', 'Pengecekan Bansos & Transparansi Penerima Manfaat — Desa Rombiya Barat')

@section('content')
<div class="min-h-screen bg-slate-50 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        
        <!-- Header Banner -->
        <div class="bg-gradient-to-br from-emerald-950 via-teal-900 to-slate-900 rounded-3xl p-8 sm:p-10 text-white shadow-lg relative overflow-hidden">
            <div class="absolute inset-0 opacity-15 bg-[radial-gradient(#10b981_1px,transparent_1px)] [background-size:20px_20px]"></div>
            
            <div class="relative z-10 max-w-3xl space-y-3">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-emerald-300 text-xs font-semibold backdrop-blur-md">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Transparansi Kesejahteraan Sosial &bull; DESA ROMBIYA Barat
                </div>
                
                <h1 class="text-2xl sm:text-4xl font-extrabold tracking-tight">
                    Pengecekan Bansos & Data Penerima Manfaat (KPM)
                </h1>
                
                <p class="text-slate-300 text-xs sm:text-sm leading-relaxed">
                    Sistem transparansi penyaluran bantuan sosial resmi dari Pemerintah Pusat (Kemensos, Bapanas/Bulog) dan Pemerintah Desa (Dana Desa APBDes). Cek apakah Anda terdaftar sebagai penerima, apa saja rincian yang akan diterima, dan jadwal pengambilan di Balai Desa.
                </p>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-8 pt-6 border-t border-white/15 relative z-10 text-center sm:text-left">
                <div>
                    <span class="text-xs text-emerald-200">Total Program Aktif</span>
                    <div class="text-xl sm:text-2xl font-black text-white mt-0.5">{{ $totalProgram }} Program</div>
                </div>
                <div>
                    <span class="text-xs text-emerald-200">Data KPM Terdata</span>
                    <div class="text-xl sm:text-2xl font-black text-emerald-300 mt-0.5">{{ number_format($totalKpm) }} Warga</div>
                </div>
                <div>
                    <span class="text-xs text-emerald-200">Cakupan Wilayah</span>
                    <div class="text-xl sm:text-2xl font-black text-white mt-0.5">5 Dusun</div>
                </div>
                <div>
                    <span class="text-xs text-emerald-200">Pusat Penyaluran</span>
                    <div class="text-xl sm:text-2xl font-black text-emerald-300 mt-0.5">Balai Desa</div>
                </div>
            </div>
        </div>

        <!-- Section 1: Formulir Cek Bansos -->
        <div id="cek-bansos" class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm">
            <div class="max-w-2xl mb-6">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-emerald-50 text-emerald-700 text-xs font-bold uppercase tracking-wider mb-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    Pencarian Status Penerima
                </div>
                <h2 class="text-xl font-extrabold text-slate-900">Cek Status Penerima Bantuan Sosial</h2>
                <p class="text-xs text-slate-600 mt-1">
                    Masukkan 16 digit Nomor Induk Kependudukan (NIK) atau Nama Lengkap Anda beserta Dusun domisili untuk memeriksa status bansos Anda.
                </p>
            </div>

            <form action="{{ route('warga.informasi.bansos') }}#hasil-cek" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-12 gap-4">
                    <!-- NIK Input -->
                    <div class="sm:col-span-4">
                        <label for="nik" class="block text-xs font-semibold text-slate-700 mb-1">Nomor Induk Kependudukan (NIK)</label>
                        <input type="text" id="nik" name="nik" value="{{ $queryNik }}" inputmode="numeric" maxlength="16"
                               placeholder="16 Digit NIK KTP..."
                               oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16);"
                               class="w-full px-4 py-3 rounded-xl border border-slate-300 text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                    </div>

                    <!-- Nama Lengkap Input -->
                    <div class="sm:col-span-4">
                        <label for="nama" class="block text-xs font-semibold text-slate-700 mb-1">Nama Lengkap (Sesuai KTP)</label>
                        <input type="text" id="nama" name="nama" value="{{ $queryNama }}"
                               placeholder="Nama Penerima / Anggota Keluarga..."
                               class="w-full px-4 py-3 rounded-xl border border-slate-300 text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                    </div>

                    <!-- Dusun Dropdown -->
                    <div class="sm:col-span-4">
                        <label for="dusun" class="block text-xs font-semibold text-slate-700 mb-1">Pilih Dusun Domisili</label>
                        <select id="dusun" name="dusun" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-xs sm:text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                            <option value="">-- Semua Dusun --</option>
                            <option value="Dusun Kebunan" {{ $queryDusun == 'Dusun Kebunan' ? 'selected' : '' }}>Dusun Kebunan</option>
                            <option value="Dusun Buwa" {{ $queryDusun == 'Dusun Buwa' ? 'selected' : '' }}>Dusun Buwa</option>
                            <option value="Dusun Tanodung" {{ $queryDusun == 'Dusun Tanodung' ? 'selected' : '' }}>Dusun Tanodung</option>
                            <option value="Dusun Rombiya" {{ $queryDusun == 'Dusun Rombiya' ? 'selected' : '' }}>Dusun Rombiya</option>
                            <option value="Dusun Kalampok" {{ $queryDusun == 'Dusun Kalampok' ? 'selected' : '' }}>Dusun Kalampok</option>
                        </select>
                    </div>
                </div>

                <div class="flex flex-wrap items-center justify-between gap-3 pt-2">
                    <div class="text-[11px] text-slate-500 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Data bersumber dari penetapan resmi DTKS Kemensos, Bapanas, dan Musyawarah Desa Rombiya Barat.
                    </div>

                    <div class="flex items-center gap-2">
                        @if($hasSearched)
                            <a href="{{ route('warga.informasi.bansos') }}" class="px-4 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-600 hover:bg-slate-100 transition-all">
                                Reset Pencarian
                            </a>
                        @endif
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs sm:text-sm font-bold shadow-md shadow-emerald-600/20 transition-all flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            Cari Status Bansos
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Section 2: Hasil Pencarian Cek Bansos -->
        @if($hasSearched)
        <div id="hasil-cek" class="space-y-6 scroll-mt-6">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase">Hasil Penelusuran Database KPM</span>
                    <h2 class="text-xl font-extrabold text-slate-900">
                        Hasil Pengecekan: {{ $hasilPencarian->count() }} Data Ditemukan
                    </h2>
                </div>
                <a href="{{ route('warga.informasi.bansos') }}" class="text-xs font-bold text-emerald-600 hover:underline">
                    &larr; Bersihkan Hasil
                </a>
            </div>

            @if($hasilPencarian->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($hasilPencarian as $kpm)
                        <div class="bg-white rounded-3xl border-2 border-emerald-300 p-6 sm:p-7 shadow-md flex flex-col justify-between relative overflow-hidden group">
                            <!-- Background Accent -->
                            <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-50 rounded-bl-full -z-0"></div>

                            <div class="relative z-10 space-y-4">
                                <!-- Top Badges -->
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <span class="px-3 py-1 rounded-full text-[11px] font-black uppercase bg-emerald-100 text-emerald-800 border border-emerald-300">
                                        ✓ TERDAFTAR SEBAGAI PENERIMA (KPM)
                                    </span>
                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold 
                                        {{ $kpm->status_penyaluran == 'siap_diambil' ? 'bg-amber-100 text-amber-800 border border-amber-300' : '' }}
                                        {{ $kpm->status_penyaluran == 'sudah_diterima' ? 'bg-emerald-100 text-emerald-800 border border-emerald-300' : '' }}
                                        {{ $kpm->status_penyaluran == 'terdaftar' ? 'bg-blue-100 text-blue-800 border border-blue-300' : '' }}">
                                        {{ $kpm->status_label }}
                                    </span>
                                </div>

                                <!-- Penerima Info -->
                                <div>
                                    <h3 class="text-lg font-extrabold text-slate-900">{{ $kpm->nama_penerima }}</h3>
                                    <p class="text-xs text-slate-500 font-mono">
                                        NIK: <strong class="text-slate-800">{{ $kpm->nik_masked }}</strong> &bull; {{ $kpm->dusun }}
                                    </p>
                                    @if($kpm->alamat_detail)
                                        <p class="text-xs text-slate-500 mt-0.5">{{ $kpm->alamat_detail }}</p>
                                    @endif
                                </div>

                                <!-- Box Rincian Bantuan yang Diterima -->
                                <div class="p-4 rounded-2xl bg-gradient-to-br from-emerald-50 to-teal-50 border border-emerald-200 space-y-2.5">
                                    <span class="text-[11px] font-bold text-emerald-800 uppercase tracking-wider block">
                                        🎁 Bantuan & Rincian yang Diterima:
                                    </span>
                                    <div class="text-sm sm:text-base font-extrabold text-emerald-950 leading-snug">
                                        {{ $kpm->rincian_yang_diterima }}
                                    </div>
                                    <div class="pt-2 border-t border-emerald-200/80 flex flex-wrap justify-between text-xs text-slate-600 gap-2">
                                        <div>
                                            <span class="text-slate-500 block text-[11px]">Program Bansos:</span>
                                            <strong class="text-slate-800">{{ $kpm->jenis_bansos }}</strong>
                                        </div>
                                        <div>
                                            <span class="text-slate-500 block text-[11px]">Periode Penyaluran:</span>
                                            <strong class="text-slate-800">{{ $kpm->periode }}</strong>
                                        </div>
                                    </div>
                                </div>

                                <!-- Jadwal & Lokasi Pengambilan -->
                                <div class="space-y-1.5 text-xs text-slate-600">
                                    <div class="flex items-start gap-2">
                                        <svg class="w-4 h-4 text-emerald-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                        <div>
                                            <span class="text-slate-500">Lokasi Pengambilan:</span>
                                            <strong class="text-slate-800 block">{{ $kpm->lokasi_pengambilan }}</strong>
                                        </div>
                                    </div>
                                    @if($kpm->tanggal_penyaluran)
                                    <div class="flex items-start gap-2">
                                        <svg class="w-4 h-4 text-teal-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <div>
                                            <span class="text-slate-500">Jadwal Penyerahan:</span>
                                            <strong class="text-slate-800 block">{{ $kpm->tanggal_penyaluran->format('d F Y') }}</strong>
                                        </div>
                                    </div>
                                    @endif
                                    @if($kpm->catatan)
                                    <div class="p-3 rounded-xl bg-amber-50 text-amber-900 border border-amber-200 mt-2">
                                        <strong>Petunjuk:</strong> {{ $kpm->catatan }}
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Bottom Action: Scan Pengumuman Pamong -->
                            <div class="relative z-10 pt-4 mt-4 border-t border-slate-100 flex items-center justify-between">
                                <span class="text-[11px] text-slate-500">Dokumen Pamong:</span>
                                @if($kpm->foto_dokumen_daftar)
                                    <button type="button" 
                                            onclick="openDocumentModal('{{ asset($kpm->foto_dokumen_daftar) }}', '{{ $kpm->nama_penerima }} — {{ $kpm->jenis_bansos }}')"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-all">
                                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        Lihat Foto Scan Daftar
                                    </button>
                                @else
                                    <span class="text-[11px] text-slate-400">Scan dokumen Balai Desa</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-3xl p-10 border border-slate-200 text-center space-y-4 shadow-sm">
                    <div class="w-14 h-14 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center mx-auto text-2xl font-bold">
                        ℹ️
                    </div>
                    <div class="max-w-md mx-auto space-y-1">
                        <h3 class="text-base font-extrabold text-slate-900">Data Tidak Ditemukan dalam Penerima Bansos</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            NIK atau Nama yang Anda cari belum terdaftar dalam daftar KPM periode aktif saat ini.
                        </p>
                    </div>
                    <div class="max-w-lg mx-auto p-4 rounded-2xl bg-slate-50 border border-slate-200 text-left text-xs text-slate-600 space-y-2">
                        <strong class="text-slate-800 block">Panduan bagi Warga yang Membutuhkan:</strong>
                        <ul class="space-y-1 list-disc list-inside">
                            <li>Bansos ditetapkan oleh pemerintah berdasarkan Data Terpadu Kesejahteraan Sosial (DTKS) & Musyawarah Desa Khusus (Musdesus).</li>
                            <li>Jika kondisi ekonomi Anda memenuhi kriteria namun belum terdata, Anda dapat berkonsultasi dengan <strong>Kepala Dusun (Kasun)</strong> setempat atau datang ke Balai Desa membawa KTP dan KK untuk diusulkan dalam pemutakhiran data DTKS berikutnya.</li>
                        </ul>
                    </div>
                </div>
            @endif
        </div>
        @endif

        <!-- Section 3: Katalog Program Bansos & Kriteria Resmi -->
        <div class="space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-2">
                <div>
                    <span class="text-xs font-bold tracking-wider text-emerald-600 uppercase">Katalog Program Pemerintah</span>
                    <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900">Macam-Macam Bantuan Sosial di Desa Rombiya Barat</h2>
                    <p class="text-xs sm:text-sm text-slate-600 mt-1">
                        Pemerintah menyalurkan berbagai macam program bantuan spesifik sesuai kelompok sasaran dan kebutuhan warga.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($programBantuan as $bansos)
                    <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-xs flex flex-col justify-between hover:border-emerald-400 hover:shadow-md transition-all group">
                        <div>
                            <!-- Header Card -->
                            <div class="flex items-center justify-between gap-2 mb-3">
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                    {{ $bansos->kategori_label }}
                                </span>
                                <span class="text-[11px] font-bold text-slate-500">TA {{ $bansos->tahun_anggaran }}</span>
                            </div>

                            <h3 class="text-base font-extrabold text-slate-900 group-hover:text-emerald-700 transition-colors mb-2">
                                {{ $bansos->nama_program }}
                            </h3>

                            <!-- Highlight Besaran -->
                            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 mb-4 space-y-1 text-xs">
                                <div class="flex justify-between">
                                    <span class="text-slate-500">Bentuk Bantuan:</span>
                                    <strong class="text-emerald-700 font-bold text-right">{{ $bansos->besaran_bantuan }}</strong>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-500">Sumber Dana:</span>
                                    <span class="text-slate-800 font-medium text-right">{{ $bansos->sumber_dana }}</span>
                                </div>
                                @if($bansos->kuota_penerima)
                                <div class="flex justify-between">
                                    <span class="text-slate-500">Alokasi Desa:</span>
                                    <span class="text-slate-800 font-bold">{{ $bansos->kuota_penerima }} KPM</span>
                                </div>
                                @endif
                            </div>

                            <!-- Detail Kriteria -->
                            <div class="space-y-3 text-xs mb-4">
                                <div>
                                    <span class="font-bold text-slate-800 block mb-0.5">Kriteria Sasaran:</span>
                                    <p class="text-slate-600 leading-relaxed">{{ $bansos->kriteria_penerima }}</p>
                                </div>

                                @if(!empty($bansos->syarat_dokumen))
                                <div>
                                    <span class="font-bold text-slate-800 block mb-1">Syarat Saat Mengambil:</span>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach((array) $bansos->syarat_dokumen as $dok)
                                            <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-700 text-[10px] font-medium">
                                                ✓ {{ $dok }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                                @if($bansos->penanggung_jawab)
                                <div class="text-[11px] text-slate-500 pt-1 border-t border-slate-100">
                                    Petugas: <strong class="text-slate-700">{{ $bansos->penanggung_jawab }}</strong>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                            <a href="#cek-bansos" class="font-bold text-emerald-600 hover:text-emerald-700 inline-flex items-center gap-1">
                                Cek Status NIK Anda &rarr;
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Section: Galeri Pengumuman Resmi Pamong & Balai Desa -->
        <div class="bg-gradient-to-br from-slate-900 via-slate-800 to-emerald-950 rounded-3xl p-6 sm:p-8 text-white shadow-md space-y-6">
            <div class="max-w-2xl">
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-400">Dokumentasi Pamong Desa</span>
                <h2 class="text-lg sm:text-2xl font-extrabold text-white mt-1">Lembar Pengumuman & Berita Acara Penyaluran</h2>
                <p class="text-xs text-slate-300 mt-1 leading-relaxed">
                    Setiap daftar penerima bantuan sosial ditempelkan secara transparan di papan pengumuman Kantor Balai Desa Rombiya Barat dan didistribusikan ke masing-masing Kepala Dusun.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Card 1: Balai Desa -->
                <div class="bg-white/10 backdrop-blur-md rounded-2xl border border-white/15 overflow-hidden group cursor-pointer"
                     onclick="openDocumentModal('{{ asset('images/balai_desa.jpeg') }}', 'Pusat Penyaluran Bansos — Kantor Balai Desa Rombiya Barat')">
                    <div class="h-44 overflow-hidden relative">
                        <img src="{{ asset('images/balai_desa.jpeg') }}" alt="Balai Desa Rombiya Barat" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent"></div>
                        <span class="absolute bottom-3 left-3 px-2.5 py-0.5 rounded-md bg-emerald-600 text-white text-[10px] font-bold">
                            Lokasi Penyaluran Resmi
                        </span>
                    </div>
                    <div class="p-4 space-y-1 text-xs">
                        <h4 class="font-bold text-white text-sm">Pusat Layanan Bansos Balai Desa</h4>
                        <p class="text-slate-300 text-[11px]">Tempat penyerahan resmi BLT Dana Desa dan Beras CBP Bulog 5 Dusun.</p>
                    </div>
                </div>

                <!-- Card 2: Pengumuman Beras CBP Bulog -->
                <div class="bg-white/10 backdrop-blur-md rounded-2xl border border-white/15 overflow-hidden group cursor-pointer"
                     onclick="openDocumentModal('{{ asset('images/balai_desa.jpeg') }}', 'Lembar Penetapan KPM Beras CBP 10 Kg — 5 Dusun')">
                    <div class="h-44 overflow-hidden relative">
                        <img src="{{ asset('images/balai_desa.jpeg') }}" alt="Pengumuman Beras CBP" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent"></div>
                        <span class="absolute bottom-3 left-3 px-2.5 py-0.5 rounded-md bg-teal-600 text-white text-[10px] font-bold">
                            Pengumuman Beras CBP
                        </span>
                    </div>
                    <div class="p-4 space-y-1 text-xs">
                        <h4 class="font-bold text-white text-sm">Daftar KPM Beras CBP 10 Kg</h4>
                        <p class="text-slate-300 text-[11px]">Alokasi 320 KPM untuk Dusun Kebunan, Buwa, Tanodung, Rombiya, Kalampok.</p>
                    </div>
                </div>

                <!-- Card 3: Pengumuman BLT Dana Desa -->
                <div class="bg-white/10 backdrop-blur-md rounded-2xl border border-white/15 overflow-hidden group cursor-pointer"
                     onclick="openDocumentModal('{{ asset('images/balai_desa.jpeg') }}', 'Berita Acara Musdesus Penetapan BLT Dana Desa 2026')">
                    <div class="h-44 overflow-hidden relative">
                        <img src="{{ asset('images/balai_desa.jpeg') }}" alt="Berita Acara BLT-DD" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent"></div>
                        <span class="absolute bottom-3 left-3 px-2.5 py-0.5 rounded-md bg-amber-600 text-white text-[10px] font-bold">
                            SK Musdesus BLT-DD
                        </span>
                    </div>
                    <div class="p-4 space-y-1 text-xs">
                        <h4 class="font-bold text-white text-sm">SK Penetapan KPM BLT Dana Desa</h4>
                        <p class="text-slate-300 text-[11px]">Penyaluran Triwulan Rp 900.000 / KPM bagi 85 keluarga miskin ekstrem.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Image / Document Lightbox Modal -->
<div id="documentModal" class="fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-sm hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-4xl w-full overflow-hidden shadow-2xl border border-slate-200">
        <div class="p-4 bg-slate-900 text-white flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <h3 id="modalTitle" class="font-bold text-sm text-white truncate">Dokumen Resmi Pamong</h3>
            </div>
            <button type="button" onclick="closeDocumentModal()" class="text-slate-400 hover:text-white p-1 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <div class="p-4 sm:p-6 max-h-[75vh] overflow-auto flex items-center justify-center bg-slate-100">
            <img id="modalImage" src="" alt="Dokumen Scan Bansos" class="max-w-full max-h-[70vh] object-contain rounded-xl shadow-md">
        </div>
        <div class="p-4 bg-slate-50 border-t border-slate-200 flex justify-end">
            <button type="button" onclick="closeDocumentModal()" class="px-5 py-2 rounded-xl bg-slate-800 text-white text-xs font-bold hover:bg-slate-700">
                Tutup Dokumen
            </button>
        </div>
    </div>
</div>

<script>
function openDocumentModal(imageSrc, title) {
    const modal = document.getElementById('documentModal');
    const modalImg = document.getElementById('modalImage');
    const modalTitle = document.getElementById('modalTitle');
    
    if (modal && modalImg) {
        modalImg.src = imageSrc;
        if (modalTitle) modalTitle.textContent = title || 'Dokumen Resmi Pamong';
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
}

function closeDocumentModal() {
    const modal = document.getElementById('documentModal');
    if (modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
}

// Close on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeDocumentModal();
    }
});
</script>
@endsection
