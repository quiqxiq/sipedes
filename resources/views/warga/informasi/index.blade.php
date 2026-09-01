@extends('layouts.app')

@section('title', 'Warta Desa & Struktur Pamong — Desa Rombiyah Barat')

@section('content')
<div class="min-h-screen bg-slate-50 py-10">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="max-w-3xl mb-10">
            <span class="text-xs font-bold tracking-wider text-emerald-600 uppercase">Pusat Informasi Publik</span>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">Warta Desa & Struktur Pamong</h1>
            <p class="text-xs sm:text-sm text-slate-600 mt-2">
                Publikasi agenda musyawarah, jadwal posyandu 5 dusun, unit usaha BUMDes Kencana, dan struktur perangkat Desa Rombiyah Barat, Kec. Ganding, Kab. Sumenep.
            </p>
        </div>

        <!-- Berita Grid -->
        <div class="mb-14">
            <h2 class="text-xl font-extrabold text-slate-900 mb-6">Warta & Pengumuman Terbaru</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($beritaList as $berita)
                    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs flex flex-col justify-between hover:border-emerald-300 hover:shadow-md transition-all">
                        <div>
                            <div class="flex items-center justify-between text-xs text-slate-500 mb-3">
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                    {{ $berita->kategori_label }}
                                </span>
                                <span>{{ $berita->published_at ? $berita->published_at->format('d M Y') : '' }}</span>
                            </div>

                            <h3 class="font-bold text-slate-900 text-sm mb-2 hover:text-emerald-600 transition-colors">
                                <a href="{{ route('warga.berita.detail', $berita->slug) }}">{{ $berita->judul }}</a>
                            </h3>

                            <p class="text-xs text-slate-600 leading-relaxed mb-4">
                                {{ Str::limit($berita->ringkasan ?? strip_tags($berita->konten), 130) }}
                            </p>
                        </div>

                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                            <span class="text-slate-400">{{ $berita->views }} kali dibaca</span>
                            <a href="{{ route('warga.berita.detail', $berita->slug) }}" class="font-bold text-emerald-600 hover:text-emerald-700">
                                Baca Selengkapnya &rarr;
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $beritaList->links() }}
            </div>
        </div>        <!-- Struktur Pamong & 5 Dusun Flowchart -->
        <div class="pt-10 border-t border-slate-200">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="text-xs font-bold tracking-wider text-emerald-600 uppercase">Pemerintahan Desa</span>
                <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 mt-1">Bagan Struktur Hierarki Pamong 5 Dusun</h2>
                <p class="text-xs text-slate-600 mt-1">Tata kelola kepemimpinan Kepala Desa {{ $profil->kepala_desa ?? 'Farhah' }}, Sekretariat, dan 5 Kepala Dusun di Desa {{ $profil->nama_desa ?? 'Rombiyah Barat' }}, {{ $profil->kecamatan ?? 'Ganding' }}, {{ $profil->kabupaten ?? 'Sumenep' }}.</p>
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

            <!-- Flowchart Box -->
            <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200 shadow-sm space-y-8">
                
                <!-- Level 1: Kades -->
                @if($kades)
                <div class="flex flex-col items-center">
                    <span class="text-[10px] font-bold text-emerald-700 uppercase bg-emerald-50 px-3 py-0.5 rounded-full mb-3 border border-emerald-200">
                        Level 1 &bull; Pimpinan Puncak
                    </span>
                    <div class="bg-gradient-to-b from-emerald-600 to-teal-700 text-white p-6 rounded-2xl text-center shadow-lg w-full max-w-xs border border-emerald-400">
                        <div class="w-20 h-20 rounded-2xl overflow-hidden border-2 border-white/80 shadow-md mx-auto mb-3 bg-slate-100">
                            <img src="{{ $kades->foto_url }}" alt="{{ $kades->nama }}" class="w-full h-full object-cover object-top">
                        </div>
                        <h3 class="font-extrabold text-base">{{ $kades->nama }}</h3>
                        <span class="text-xs text-emerald-100 font-semibold block">{{ $kades->jabatan }}</span>
                        @if($kades->nip_atau_nomor)
                            <span class="text-[10px] text-emerald-200/80 block mt-0.5">NIP: {{ $kades->nip_atau_nomor }}</span>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Connector 1 -> 2 -->
                <div class="flex justify-center -my-3">
                    <div class="flex flex-col items-center">
                        <div class="w-0.5 h-8 bg-emerald-400"></div>
                        <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-ping -mt-1"></div>
                    </div>
                </div>

                <!-- Level 2: Sekdes & Staf -->
                @if($sekretariat->count() > 0)
                <div class="flex flex-col items-center">
                    <span class="text-[10px] font-bold text-teal-700 uppercase bg-teal-50 px-3 py-0.5 rounded-full mb-3 border border-teal-200">
                        Level 2 &bull; Sekretariat Desa & Pelaksana Teknis
                    </span>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 w-full max-w-4xl">
                        @foreach($sekretariat as $staf)
                            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 text-center hover:border-teal-400 transition-all">
                                <div class="w-14 h-14 rounded-xl overflow-hidden border-2 border-teal-200 shadow-xs mx-auto mb-2 bg-slate-100">
                                    <img src="{{ $staf->foto_url }}" alt="{{ $staf->nama }}" class="w-full h-full object-cover object-top">
                                </div>
                                <h4 class="font-bold text-xs text-slate-900">{{ $staf->nama }}</h4>
                                <span class="text-[10px] font-bold text-teal-700 block mt-0.5">{{ $staf->jabatan }}</span>
                                <span class="text-[10px] text-slate-500 block">{{ $staf->wilayah_tugas ?? 'Kantor Balai Desa' }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Connector 2 -> 3 -->
                <div class="flex justify-center -my-3">
                    <div class="flex flex-col items-center">
                        <div class="w-0.5 h-8 bg-teal-400"></div>
                        <div class="w-2.5 h-2.5 rounded-full bg-teal-500 animate-ping -mt-1"></div>
                    </div>
                </div>

                <!-- Level 3: Kepala Dusun -->
                @if($kepalaDusun->count() > 0)
                <div class="flex flex-col items-center">
                    <span class="text-[10px] font-bold text-emerald-800 uppercase bg-emerald-100 px-3 py-0.5 rounded-full mb-3 border border-emerald-300">
                        Level 3 &bull; Unsur Kewilayahan (Kepala Dusun)
                    </span>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 w-full">
                        @foreach($kepalaDusun as $kasun)
                            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 text-center hover:border-emerald-400 transition-all">
                                <div class="w-14 h-14 rounded-xl overflow-hidden border-2 border-emerald-300 shadow-xs mx-auto mb-2 bg-slate-100">
                                    <img src="{{ $kasun->foto_url }}" alt="{{ $kasun->nama }}" class="w-full h-full object-cover object-top">
                                </div>
                                <span class="text-[10px] font-bold text-emerald-700 uppercase block">{{ $kasun->wilayah_tugas ?? $kasun->jabatan }}</span>
                                <h4 class="font-bold text-xs text-slate-900 mt-0.5">{{ $kasun->nama }}</h4>
                                <span class="text-[10px] text-slate-500 block">{{ $kasun->jabatan }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>
        </div>

    </div>
</div>
@endsection
