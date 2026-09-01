@extends('layouts.app')

@section('title', $berita->judul . ' — Desa Rombiyah Barat')

@section('content')
<div class="min-h-screen bg-slate-50 py-10">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-6">
            <a href="{{ route('warga.informasi.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-600 hover:text-emerald-700">
                &larr; Kembali ke Warta Desa
            </a>
        </div>

        <article class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200 shadow-sm space-y-6">
            <div class="space-y-3 border-b border-slate-100 pb-6">
                <div class="flex items-center gap-3 text-xs text-slate-500">
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                        {{ $berita->kategori_label }}
                    </span>
                    <span>📅 {{ $berita->published_at ? $berita->published_at->format('d M Y, H:i') : '' }} WIB</span>
                    <span>&bull;</span>
                    <span>👁️ {{ $berita->views }} kali dibaca</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 leading-tight">
                    {{ $berita->judul }}
                </h1>
            </div>

            @if($berita->gambar_cover)
                <div class="rounded-2xl overflow-hidden border border-slate-200">
                    <img src="{{ asset('storage/' . $berita->gambar_cover) }}" alt="{{ $berita->judul }}" class="w-full h-auto object-cover max-h-96">
                </div>
            @endif

            <div class="prose max-w-none text-slate-700 text-sm leading-relaxed space-y-4">
                {!! nl2br(e($berita->konten)) !!}
            </div>

            <div class="pt-6 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <span>Diterbitkan oleh: <strong>Pemerintah Desa Rombiyah Barat</strong></span>
                <a href="{{ route('warga.informasi.index') }}" class="font-bold text-emerald-600 hover:underline">
                    Warta Lainnya &rarr;
                </a>
            </div>
        </article>

        @if($beritaTerkait->count() > 0)
            <div class="mt-10">
                <h3 class="font-bold text-slate-900 text-base mb-4">Warta & Informasi Terkait Lainnya</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    @foreach($beritaTerkait as $terkait)
                        <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-xs hover:border-emerald-300 transition-all">
                            <span class="text-[10px] text-emerald-700 font-bold block mb-1">{{ $terkait->kategori_label }}</span>
                            <h4 class="font-bold text-xs text-slate-900 line-clamp-2 mb-2">
                                <a href="{{ route('warga.berita.detail', $terkait->slug) }}" class="hover:text-emerald-600">
                                    {{ $terkait->judul }}
                                </a>
                            </h4>
                            <span class="text-[10px] text-slate-400">{{ $terkait->published_at ? $terkait->published_at->format('d M Y') : '' }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
