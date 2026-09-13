@extends('layouts.app')

@section('title', 'Lapor Pengaduan & Aspirasi Warga — Desa Rombiya Barat')

@section('content')
<div class="min-h-screen bg-slate-50 py-10">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Card -->
        <div class="mb-8">
            <a href="{{ route('warga.pengaduan.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-600 hover:text-emerald-700 mb-3">
                &larr; Lihat Riwayat Laporan Saya
            </a>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Lapor Pengaduan & Aspirasi Warga</h1>
            <p class="text-xs sm:text-sm text-slate-600 mt-1">
                Sampaikan aspirasi atau keluhan mengenai fasilitas umum, irigasi sawah, pupuk, jalan dusun, atau bansos di wilayah Desa Rombiya Barat, Kec. Ganding.
            </p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm">
            <form action="{{ route('warga.pengaduan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Dusun & Kategori Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="dusun" class="block text-xs font-bold text-slate-700 mb-1">Lokasi Wilayah Dusun <span class="text-rose-500">*</span></label>
                        <select id="dusun" name="dusun" required
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 outline-none @error('dusun') border-rose-500 @enderror">
                            <option value="">-- Pilih Dusun --</option>
                            @foreach($dusunList as $dusun)
                                <option value="{{ $dusun }}" {{ old('dusun') == $dusun ? 'selected' : '' }}>{{ $dusun }}</option>
                            @endforeach
                        </select>
                        @error('dusun')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="kategori" class="block text-xs font-bold text-slate-700 mb-1">Kategori Masalah <span class="text-rose-500">*</span></label>
                        <select id="kategori" name="kategori" required
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 outline-none @error('kategori') border-rose-500 @enderror">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="pertanian_irigasi" {{ old('kategori') == 'pertanian_irigasi' ? 'selected' : '' }}>Pertanian & Irigasi / Pupuk</option>
                            <option value="jalan_infrastruktur" {{ old('kategori') == 'jalan_infrastruktur' ? 'selected' : '' }}>Jalan & Infrastruktur Dusun</option>
                            <option value="bansos" {{ old('kategori') == 'bansos' ? 'selected' : '' }}>Bantuan Sosial & Kesejahteraan</option>
                            <option value="kebersihan_lingkungan" {{ old('kategori') == 'kebersihan_lingkungan' ? 'selected' : '' }}>Kebersihan & Lingkungan</option>
                            <option value="pelayanan_desa" {{ old('kategori') == 'pelayanan_desa' ? 'selected' : '' }}>Pelayanan Balai Desa</option>
                            <option value="lainnya" {{ old('kategori') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('kategori')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Judul Laporan -->
                <div>
                    <label for="judul" class="block text-xs font-bold text-slate-700 mb-1">Judul Laporan <span class="text-rose-500">*</span></label>
                    <input id="judul" name="judul" type="text" value="{{ old('judul') }}" required placeholder="Contoh: Rabat beton jalan tani ambles dekat batas sawah RT 02"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 outline-none @error('judul') border-rose-500 @enderror">
                    @error('judul')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Detail Lokasi -->
                <div>
                    <label for="lokasi_detail" class="block text-xs font-bold text-slate-700 mb-1">Detail Titik Lokasi (Opsional)</label>
                    <input id="lokasi_detail" name="lokasi_detail" type="text" value="{{ old('lokasi_detail') }}" placeholder="Contoh: RT 003 RW 002, 100m timur musholla Dusun Kebunan"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 outline-none @error('lokasi_detail') border-rose-500 @enderror">
                    @error('lokasi_detail')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Isi Laporan -->
                <div>
                    <label for="deskripsi" class="block text-xs font-bold text-slate-700 mb-1">Isi Lengkap Laporan / Keluhan <span class="text-rose-500">*</span></label>
                    <textarea id="deskripsi" name="deskripsi" rows="5" required placeholder="Jelaskan secara rinci kronologi, lokasi, dan bantuan/tindakan yang diharapkan dari pihak desa..."
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 outline-none @error('deskripsi') border-rose-500 @enderror">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Upload Foto -->
                <div x-data="{ 
                        fileName: '', 
                        fileSize: '',
                        handleFileChange(e) {
                            const file = e.target.files[0];
                            if (file) {
                                this.fileName = file.name;
                                this.fileSize = Math.round(file.size / 1024) + ' KB';
                            } else {
                                this.fileName = '';
                                this.fileSize = '';
                            }
                        }
                    }">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Foto Bukti Lapangan (Opsional, Maks 3MB)</label>
                    <label for="foto_lampiran" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 p-3 bg-white rounded-xl border {{ (isset($errors) && $errors->has('foto_lampiran')) ? 'border-rose-400 ring-1 ring-rose-300' : 'border-slate-300 hover:border-emerald-500' }} hover:bg-emerald-50/20 transition-all cursor-pointer group shadow-2xs">
                        <input id="foto_lampiran" 
                               name="foto_lampiran" 
                               type="file" 
                               accept="image/png,image/jpeg,image/jpg"
                               @change="handleFileChange($event)"
                               class="sr-only">

                        <span class="inline-flex items-center justify-center gap-2 px-3.5 py-2 rounded-lg bg-emerald-600 group-hover:bg-emerald-700 text-white font-semibold text-xs transition-colors shrink-0 shadow-xs">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            </svg>
                            <span>Pilih Berkas</span>
                        </span>

                        <div class="flex-1 min-w-0 text-xs">
                            <template x-if="fileName">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="font-medium text-emerald-800 truncate flex items-center gap-1.5">
                                        <span>📷</span>
                                        <span class="truncate" x-text="fileName"></span>
                                    </span>
                                    <span class="text-slate-400 font-mono text-[11px] shrink-0 ml-1" x-text="fileSize"></span>
                                </div>
                            </template>
                            <template x-if="!fileName">
                                <span class="text-slate-400 font-normal">Belum ada berkas dipilih (Format: JPG, JPEG, PNG - Maks 3MB)</span>
                            </template>
                        </div>
                    </label>
                    <p class="text-[11px] text-slate-500 mt-1.5">Unggah foto jalan rusak, saluran irigasi, atau kondisi terkait agar petugas dapat memverifikasi lebih cepat.</p>
                    @error('foto_lampiran')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                    <a href="{{ route('warga.landing') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-800">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs shadow-md shadow-emerald-600/20 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                        Kirim Laporan Pengaduan
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
