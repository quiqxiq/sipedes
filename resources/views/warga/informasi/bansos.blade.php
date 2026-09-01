@extends('layouts.app')

@section('title', 'Katalog Bantuan Sosial (Bansos) — Desa Rombiyah Barat')

@section('content')
<div class="min-h-screen bg-slate-50 py-10">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="max-w-3xl mb-10">
            <span class="text-xs font-bold tracking-wider text-emerald-600 uppercase">Transparansi Kesejahteraan Sosial</span>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">Program Bantuan Sosial (Bansos) Desa</h1>
            <p class="text-xs sm:text-sm text-slate-600 mt-2">
                Informasi resmi program bantuan pemerintah yang disalurkan kepada warga di 5 Dusun Desa Rombiyah Barat, Kecamatan Ganding, Kabupaten Sumenep.
            </p>
        </div>

        <!-- Bansos Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($programBantuan as $bansos)
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm flex flex-col justify-between hover:border-emerald-300 transition-all">
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-3">
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                {{ $bansos->kategori_label }}
                            </span>
                            @if($bansos->status === 'dibuka')
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-blue-100 text-blue-800">
                                    Pendaftaran Dibuka
                                </span>
                            @elseif($bansos->status === 'penyaluran')
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">
                                    Sedang Disalurkan
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-slate-100 text-slate-700">
                                    {{ ucfirst($bansos->status) }}
                                </span>
                            @endif
                        </div>

                        <h2 class="text-lg font-bold text-slate-900 mb-2">{{ $bansos->nama_program }}</h2>
                        
                        <div class="space-y-3 text-xs mb-6">
                            <div class="p-3.5 rounded-xl bg-slate-50 space-y-1.5">
                                <div class="flex justify-between">
                                    <span class="text-slate-500">Sumber Anggaran:</span>
                                    <strong class="text-slate-800">{{ $bansos->sumber_dana }}</strong>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-500">Bentuk / Besaran:</span>
                                    <strong class="text-emerald-700 font-bold">{{ $bansos->besaran_bantuan }}</strong>
                                </div>
                                @if($bansos->kuota_penerima)
                                    <div class="flex justify-between">
                                        <span class="text-slate-500">Target Alokasi:</span>
                                        <strong class="text-slate-800">{{ $bansos->kuota_penerima }} Keluarga Penerima Manfaat</strong>
                                    </div>
                                @endif
                            </div>

                            <div>
                                <strong class="text-slate-700 block mb-1">Kriteria Penerima:</strong>
                                <p class="text-slate-600 leading-relaxed">{{ $bansos->kriteria_penerima }}</p>
                            </div>

                            @if(!empty($bansos->syarat_dokumen))
                                <div>
                                    <strong class="text-slate-700 block mb-1">Persyaratan Dokumen:</strong>
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach((array) $bansos->syarat_dokumen as $dok)
                                            <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 text-[11px]">
                                                ✓ {{ $dok }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if($bansos->keterangan)
                                <div class="p-3 rounded-xl bg-amber-50/60 border border-amber-100 text-amber-900">
                                    <strong>Catatan:</strong> {{ $bansos->keterangan }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-500">Tahun Anggaran {{ $bansos->tahun_anggaran }}</span>
                        <a href="{{ route('warga.pengajuan.wizard') }}" class="font-bold text-emerald-600 hover:text-emerald-700">
                            Ajukan Surat SKTM Pendukung &rarr;
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</div>
@endsection
